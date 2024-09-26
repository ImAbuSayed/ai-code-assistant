<?php

namespace App\Livewire;

use Livewire\Component;
use OpenAI\Client;

class AIAssistant extends Component
{
    public $question;
    public $answer;

    public function render()
    {
        return view('livewire.a-i-assistant');
    }

    public function askQuestion()
    {
        $client = \OpenAI::client(env('OPENAI_API_KEY'));

        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful programming assistant, specializing in Laravel, Livewire, and web development.'],
                ['role' => 'user', 'content' => $this->question],
            ],
        ]);

        $this->answer = $response->choices[0]->message->content;
    }
}
