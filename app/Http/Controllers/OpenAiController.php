<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;

class OpenAiController extends Controller
{
    public function handle(Request $request)
    {
        $message = $request->input('message');
        $fullHtml = $request->input('fullHtml');
        $selectedHtml = $request->input('selectedHtml');

        // Retrieve chat history from session
        $chatHistory = session('chat_history', []);

        // Add the new user message to the chat history
        $chatHistory[] = ['role' => 'user', 'content' => $message];

        // Create the OpenAI client with your API key
        $client = OpenAI::client('sk-proj-qnlQwFb9dGPIGQVOVATJT3BlbkFJ3cZx9iYYIrFRA6cE3x7N');

        try {
            // Add a system prompt to provide context
            $systemPrompt = "You are a helpful assistant that generates HTML code snippets based on user input. Ensure the output is clean, well-structured, and uses TailwindCSS for styling. Use the provided full page HTML and the selected HTML element to generate context-aware responses. Return a structured JSON response with two parts: 'html' containing the HTML code and 'summary' containing a summary of changes.";

            // Prepare the messages for the AI service
            $messages = [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => "Full HTML: {$fullHtml}\nSelected HTML: {$selectedHtml}\nUser Message: {$message}"],
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
                        "html" => ["type" => "string"],
                        "summary" => ["type" => "string"]
                    ],
                    "required" => ["html", "summary"],
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

            // Check if the response contains the expected keys
            if (isset($result['choices'][0]['message']['content'])) {
                $aiResponse = json_decode($result['choices'][0]['message']['content'], true);

                // Add the AI response to the chat history
                $chatHistory[] = ['role' => 'assistant', 'content' => json_encode($aiResponse)];

                // Store the updated chat history in the session
                session(['chat_history' => $chatHistory]);

                return response()->json([
                    'response' => $aiResponse,
                    'html' => $aiResponse['html'],
                    'summary' => $aiResponse['summary'],
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