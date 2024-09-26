<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CodeSnippet;
use OpenAI\Client;

class CodeReviewer extends Component
{
    public $code;
    public $language;
    public $analysis;

    protected $rules = [
        'code' => 'required',
        'language' => 'required',
    ];

    public function render()
    {
        return view('livewire.code-reviewer');
    }

    public function analyzeCode()
    {
        $this->validate();

        $client = \OpenAI::client(env('OPENAI_API_KEY'));

        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'You are an expert code reviewer.'],
                ['role' => 'user', 'content' => "Analyze this {$this->language} code and provide improvement suggestions, best practices, and security checks:\n\n{$this->code}"],
            ],
        ]);

        $this->analysis = $response->choices[0]->message->content;

        CodeSnippet::create([
            'code' => $this->code,
            'language' => $this->language,
            'analysis' => $this->analysis,
        ]);
    }
}
