<?php

namespace App\Livewire;

use App\Models\UserMessage;
use Livewire\Component;
use OpenAI;

class CreateInvoice extends Component
{
    public $userPrompt = "";
    public $aiResponse = [];
    public $loading = false;
    public $step = 0;
    public $chatHistory = [];
    public $invoice_template;
    public $company_details;

    public function render()
    {
        return view('livewire.create-invoice');
    }

    public function start()
    {
        $this->step++;
        $this->company_details = "
        Įmonės pavadinimas: 
        Direktorius: 
        Adresas:
        Mob.telefonas:
        Vadovo telefonas:
        El. pašto adresas:
        Tinklalapis:
        ";
        $this->loading = true;
      
        $this->dispatch('some-event'); // Useless
        // Save user message
        $saved_message = new UserMessage();
        $saved_message->message = $this->userPrompt;
        $saved_message->role = 'user';
        $saved_message->chat_id = 1;
        $saved_message->save();

        // Add user message to chat history
        $this->chatHistory[] = ['role' => 'user', 'content' => $this->userPrompt . 'This is Business details to use for invoice sender: '. $this->company_details .'. This is the current template:' . $this->invoice_template];

        // Clear input field
        $this->userPrompt = "";

        // Trigger the response after setting the chat
        $this->response();
    }

    public function response()
    {
        $this->loading = true;

        $message = end($this->chatHistory)['content'];

        // Load the invoice template from file
        $path = resource_path('views/templates/invoice-template.blade.php');
        $templateContent = file_get_contents($path);

        // Add current template to the message for the AI

        // Create the OpenAI client with your API key
        $client = OpenAI::client(config('app.open_ai_key'));

        try {
            // System prompt to guide the AI response
            $systemPrompt = "You are a helpful assistant that provides assistance on accounting questions in Lithuania. You are an expert accountant and can answer questions about taxes, compliance, relevant dates, and provide reports to upper management. You generate invoice templates and list any missing questions required to complete an invoice. Please ensure you use this Invoice template with details about customer information. Template code you must use: " . $templateContent;

            // Prepare the messages for the AI service
            $messages = array_merge(
                [['role' => 'system', 'content' => $systemPrompt]],
                $this->chatHistory
            );

            // Define the JSON schema for the structured response
            $jsonSchema = [
                "name" => "structured_response",
                "strict" => true,
                "schema" => [
                    "type" => "object",
                    "properties" => [
                        "template" => ["type" => "string", "description" => "Make an HTML invoice template"],
                        "missing_questions" => ["type" => "array", "items" => ["type" => "string"]],
                        "suggestions" => ["type" => "string"]
                    ],
                    "required" => ["template", "missing_questions", "suggestions"],
                    "additionalProperties" => false
                ]
            ];

            // Call the AI service
            $result = $client->chat()->create([
                'model' => 'gpt-4o-mini', // Assistant model name
                'messages' => $messages,
                'response_format' => [
                    'type' => 'json_schema',
                    'json_schema' => $jsonSchema
                ],
                'max_tokens' => 1500,
            ]);

            // Parse the AI response
            if (isset($result['choices'][0]['message']['content'])) {
                $aiResponseContent = $result['choices'][0]['message']['content'];
                $aiResponse = json_decode($aiResponseContent, true);

                // Check for JSON errors
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception('Invalid JSON in AI response: ' . json_last_error_msg());
                }

                // Save AI response in the chat history
                if (isset($aiResponse['missing_questions']) && is_array($aiResponse['missing_questions'])) {
                    // Convert missing questions array to string
                    $missingQuestions = implode(', ', $aiResponse['missing_questions']);
                    $this->chatHistory[] = ['role' => 'assistant', 'content' => "Missing questions: " . $missingQuestions];
                }

                // Assign template if it is valid
                $this->invoice_template = is_string($aiResponse['template']) ? $aiResponse['template'] : 'Invalid template format';

                // Save the AI response in a database (if needed)
                $saved_message = new UserMessage();
                $saved_message->message = json_encode($aiResponse);
                $saved_message->role = 'assistant';
                $saved_message->chat_id = 1;
                $saved_message->save();

                // Add other assistant responses like suggestions
                if (isset($aiResponse['suggestions'])) {
                    $this->chatHistory[] = ['role' => 'assistant', 'content' => $aiResponse['suggestions']];
                }

                // Assign the response data to the component's property
                $this->aiResponse = [
                    'template' => $this->invoice_template,
                    'missing_questions' => $aiResponse['missing_questions'],
                    'suggestions' => $aiResponse['suggestions'],
                ];

            } else {
                throw new \Exception('Unexpected response structure');
            }
        } catch (\Exception $e) {
            // Handle the exception and display error in UI
            $this->aiResponse = [
                'error' => 'An error occurred while processing your request.',
                'details' => $e->getMessage(),
            ];

            // Add error message to chat history
            $this->chatHistory[] = [
                'role' => 'assistant',
                'content' => "Error: " . $e->getMessage()
            ];
        } finally {
            // Set loading to false after the operation is complete
            $this->loading = false;
        }
    }
}
