<?php

namespace App\Livewire;

use Livewire\Component;

use OpenAI;

class CreateInvoice extends Component
{

    public $userPrompt = "";
    public $aiResponse;
    public $loading = false;
    public $step = 0;
    public $chatHistory = [];

    public function render()
    {
        return view('livewire.create-invoice');
    }

    public function start() {
        $this->loading = true;
        $this->step++;
        array_push($this->chatHistory, $this->userPrompt);
        $this->response();
        $this->userPrompt = "";
        // dd($this->userPrompt);
    }


    public function response()
    {
        $message = $this->userPrompt;
       

        // Retrieve chat history from session
        $chatHistory = session('chat_history', []);

        // Add the new user message to the chat history
        $chatHistory[] = ['role' => 'user', 'content' => $message];
        // Create the OpenAI client with your API key
        $client = OpenAI::client(config('app.open_ai_key'));

        try {
            // Add a system prompt to provide context
            $systemPrompt = "You are a helpful assistant that provides assitance on accounting questions in Lithuania.You are expert accountant and can answert questions about taxes, compliance, relevant dates and provide reports to upper management. You provide extra options for the user to continue conversation in suggestions field";

            // Prepare the messages for the AI service
            $messages = [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => "{$message}"],
            ];

            // Include the chat history in the messages
            foreach ($chatHistory as $chatMessage) {
                $messages[] = $chatMessage;
            }

            // Define the JSON schema for the structured response
            $jsonSchema = [
                "name" => "structured_response",
                "strict" => true,
                "schema" => [
                    "type" => "object",
                    "properties" => [
                        "suggestions" => ["type" => "string"],
                        "summary" => ["type" => "string"]
                    ],
                    "required" => ["suggestions", "summary"],
                    "additionalProperties" => false
                ]
            ];

            // Call the AI service (e.g., OpenAI GPT-4o)
            $result = $client->chat()->create([
                'model' => 'gpt-4o-2024-08-06', // Assistant name
                'messages' => $messages,
                'response_format' => [
                    'type' => 'json_schema',
                    'json_schema' => $jsonSchema
                ],
                'max_tokens' => 15000,
            ]);
            // dd($result);
            // Check if the response contains the expected keys
            if (isset($result['choices'][0]['message']['content'])) {
                $aiResponse = json_decode($result['choices'][0]['message']['content'], true);
                // dd($aiResponse);
                $this->loading = false;
                // Add the AI response to the chat history
                $this->chatHistory[] = ['role' => 'assistant', 'content' => $aiResponse['summary']];

              
                $aiResponse = response()->json([
                    'response' => $aiResponse,
                    'summary' => $aiResponse['summary'],
                    'data' => $aiResponse['suggestions'],

                ]);
            } else {
                throw new \Exception('Unexpected response structure');
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while processing your request.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
