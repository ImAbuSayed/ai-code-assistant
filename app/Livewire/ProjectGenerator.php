<?php

namespace App\Livewire;

use App\Models\Project;
use Highlight\Highlighter;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use ZipArchive;

class ProjectGenerator extends Component
{
    public $projectName;

    public $projectDescription;

    public $projectStructure;

    public $currentStep = 'init';

    public $generatedFiles = [];

    public $currentFile = '';

    public $conversation = '[]'; // Initialize as an empty JSON string

    public $progress = 0;

    public $totalFiles = 0;

    public $downloadLink = '';

    protected $rules = [
        'projectName' => 'required|min:3',
        'projectDescription' => 'required|min:10',
    ];

    public $projectOptions = [
        'auth' => false,
        'api' => false,
        'admin' => false,
    ];

    public function render()
    {
        return view('livewire.project-generator');
    }

    public function generateProject()
    {
        $this->validate();

        $this->currentStep = 'structure';
        $this->conversation = json_encode([
            ['role' => 'system', 'content' => 'You are an expert Laravel developer. You will help create a complete Laravel 11 project with Livewire 3 components step by step.'],
            ['role' => 'user', 'content' => "Generate a complete Laravel 11 project structure with Livewire 3 components for the following project:\n\nName: {$this->projectName}\nDescription: {$this->projectDescription}\n\nProject Options:\n".$this->getProjectOptionsString()."\n\nProvide a detailed directory structure and file list, including models, migrations, controllers, Livewire components, and views."],
        ]);

        $this->getNextStep();
    }

    private function getProjectOptionsString()
    {
        $options = [];
        foreach ($this->projectOptions as $option => $enabled) {
            if ($enabled) {
                $options[] = ucfirst($option);
            }
        }

        return implode(', ', $options);
    }

    public function highlightCode($code, $language)
    {
        $highlighter = new Highlighter;
        $highlighted = $highlighter->highlight($language, $code);

        return $highlighted->value;
    }

    public function getNextStep()
    {
        $client = \OpenAI::client(env('OPENAI_API_KEY'));

        $conversationArray = json_decode($this->conversation, true);

        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => $conversationArray,
        ]);

        $aiResponse = $response->choices[0]->message->content;
        $conversationArray[] = ['role' => 'assistant', 'content' => $aiResponse];
        $this->conversation = json_encode($conversationArray);

        switch ($this->currentStep) {
            case 'structure':
                $this->projectStructure = $aiResponse;
                $this->currentStep = 'file_list';
                $conversationArray[] = ['role' => 'user', 'content' => "Great! Now, provide a list of all the files we need to create for this project, including their full paths. Format the response as a JSON object where keys are file paths and values are file types (e.g., 'model', 'controller', 'view', 'migration', etc.)."];
                $this->conversation = json_encode($conversationArray);
                break;
            case 'file_list':
                $this->generatedFiles = $this->parseFileList($aiResponse);
                $this->totalFiles = count($this->generatedFiles);
                $this->currentStep = 'generate_files';
                $this->generateNextFile();
                break;
            case 'generate_files':
                $this->saveGeneratedFile($aiResponse);
                if (! empty($this->generatedFiles)) {
                    $this->generateNextFile();
                } else {
                    $this->currentStep = 'complete';
                    $this->createZipArchive();
                    $conversationArray[] = ['role' => 'user', 'content' => "The project is now complete. Please provide a summary of what we've created and any next steps or recommendations for the developer."];
                    $this->conversation = json_encode($conversationArray);
                }
                break;
            case 'complete':
                $this->projectStructure .= "\n\nProject Summary:\n".$aiResponse;
                $this->saveProject();
                break;
        }

        if ($this->currentStep != 'complete') {
            $this->getNextStep();
        }
    }

    private function parseFileList($fileList)
    {
        $files = json_decode($fileList, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $files;
        }

        // Fallback to simple parsing if JSON decoding fails
        return array_fill_keys(array_filter(explode("\n", $fileList)), 'unknown');
    }

    private function generateNextFile()
    {
        if (! empty($this->generatedFiles)) {
            $this->currentFile = key($this->generatedFiles);
            $fileType = current($this->generatedFiles);
            array_shift($this->generatedFiles);
            $this->progress = round((($this->totalFiles - count($this->generatedFiles)) / $this->totalFiles) * 100);
            $conversationArray = json_decode($this->conversation, true);
            $conversationArray[] = ['role' => 'user', 'content' => "Please generate the complete code for the file: {$this->currentFile}\nThis is a {$fileType} file."];
            $this->conversation = json_encode($conversationArray);
        }
    }

    private function createZipArchive()
    {
        $zipFileName = 'generated_project.zip';
        $zip = new ZipArchive;

        if ($zip->open(Storage::path($zipFileName), ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $files = Storage::allFiles('generated_project');
            foreach ($files as $file) {
                $zip->addFile(Storage::path($file), $file);
            }
            $zip->close();
        }

        $this->downloadLink = url('download-project');
    }

    private function saveGeneratedFile($content)
    {
        $relativePath = 'generated_project/'.$this->currentFile;
        $directory = dirname($relativePath);

        // Ensure the directory exists
        if (! Storage::exists($directory)) {
            Storage::makeDirectory($directory, 0755, true);
        }

        // Save the file
        Storage::put($relativePath, $content);

        // Determine the language based on file extension
        $extension = pathinfo($this->currentFile, PATHINFO_EXTENSION);
        $language = $this->getLanguageFromExtension($extension);

        // Highlight the code
        $this->currentFile = [
            'path' => $this->currentFile,
            'content' => $this->highlightCode($content, $language),
        ];
    }

    private function getLanguageFromExtension($extension)
    {
        $languageMap = [
            'php' => 'php',
            'js' => 'javascript',
            'css' => 'css',
            'html' => 'html',
            'blade.php' => 'php',
            // Add more mappings as needed
        ];

        return $languageMap[$extension] ?? 'plaintext';
    }

    private function saveProject()
    {
        Project::create([
            'name' => $this->projectName,
            'description' => $this->projectDescription,
            'structure' => $this->projectStructure,
        ]);
    }
}
