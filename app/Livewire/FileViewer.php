<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class FileViewer extends Component
{
    public $files = [];

    public $selectedFile = null;

    public $fileContent = '';

    public $isEditing = false;

    public $editedContent = '';

    public function mount()
    {
        $this->refreshFileList();
    }

    public function render()
    {
        return view('livewire.file-viewer');
    }

    // app/Livewire/FileViewer.php

    public function refreshFileList()
    {
        $dir = storage_path('app/generated_project');
        if (! file_exists($dir)) {
            $this->files = [];
        } else {
            $this->files = $this->getFiles($dir);
        }
    }

    private function getFiles($dir)
    {
        $files = [];
        if (is_dir($dir)) {
            foreach (scandir($dir) as $file) {
                if ($file !== '.' && $file !== '..') {
                    $path = $dir.'/'.$file;
                    if (is_dir($path)) {
                        $files[$file] = $this->getFiles($path);
                    } else {
                        $files[] = $file;
                    }
                }
            }
        }

        return $files;
    }

    public function editFile()
    {
        $this->isEditing = true;
        $this->editedContent = $this->fileContent;
    }

    public function saveFile()
    {
        Storage::put('generated_project/'.$this->selectedFile, $this->editedContent);
        $this->fileContent = $this->editedContent;
        $this->isEditing = false;
    }

    public function cancelEdit()
    {
        $this->isEditing = false;
    }

    public function selectFile($file)
    {
        $this->selectedFile = $file;
        $this->fileContent = Storage::get('generated_project/'.$file);
    }
}
