<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ChatComponent extends Component
{
    public $message;
    public $fullHtml;
    public $selectedHtml;
    public $responseHtml;
    public $summary;
    public $error;
    public function mount() {
       
    }
    
    public function sendMessage()
        {
            $this->error = null;
            
            // Validate input
            $this->validate([
                'message' => 'required|string',
                'fullHtml' => 'nullable|string',
                'selectedHtml' => 'nullable|string',
            ]);
    
            try {
                // Send request to the OpenAiController
                $response = Http::post(route('openai.handle'), [
                    'message' => $this->message,
                    'fullHtml' => $this->fullHtml,
                    'selectedHtml' => $this->selectedHtml,
                ]);
    
                $data = $response->json();
    
                if (isset($data['response'])) {
                    // Store response details
                    $this->responseHtml = $data['html'];
                    $this->summary = $data['summary'];
                } else {
                    $this->error = $data['error'] ?? 'An unexpected error occurred.';
                }
            } catch (\Exception $e) {
                $this->error = $e->getMessage();
            }
    }


    public function render()
    {
        return view('livewire.chat-component');
    }
}
