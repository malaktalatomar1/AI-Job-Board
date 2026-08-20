<?php

namespace App\Livewire;

use App\Services\AIChatbotService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Chatbot extends Component
{
    public bool $open = false;

    public string $question = '';

    public array $messages = [];


    public function toggleChat(): void
    {
        $this->open = ! $this->open;
    }


    public function ask(): void
    {
        $question = trim($this->question);

        if ($question === '') {
            return;
        }


        // Add user message
        $this->messages[] = [
            'role' => 'user',
            'message' => $question,
        ];


        // Clear input
        $this->question = '';


        try {

            $user = Auth::user();

            if (!$user) {

                $answer = 'Please login first.';

            } else {

                $service = app(AIChatbotService::class);

                $answer = $service->ask(
                    $user,
                    $question
                );
            }

        } catch (\Throwable $e) {

            Log::error(
                'Chatbot Error',
                [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );

            $answer = 'Sorry, something went wrong while contacting the AI.';
        }


        // Add AI response
        $this->messages[] = [
            'role' => 'assistant',
            'message' => $answer,
        ];
    }


   public function render()
{
    return view('components.chatbot');
}
}