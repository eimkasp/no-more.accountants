<?php

namespace App\Livewire;

use App\Models\Upload;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use OpenAI;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Url;



class UploadInvoice extends Component
{
     
    #[Url] 
    public $activeTab = 'upload';


    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }
    
    public $userPrompt = "";
    public $aiResponse = [];
    public $loading = false;
    public $step = 0;
    public $chatHistory = [];
    public $invoice_template;

    public function start()
    {
        $this->loading = true;
        $this->step++;
        $this->chatHistory = [];
        $this->response();
        $this->userPrompt = "";
    }
    
    public function submit(): void
    {

        foreach ($this->photos as $photo) {
            // Save the file in storage
            $filePath = Storage::putFile('photos', new File($photo['path']));
            
            // Store file information in the database
            $upload = Upload::create([
                'company_id' => 1, // Replace this with actual company ID if needed
                'invoice_id' => null, // Add invoice ID if available
                'file_name' => basename($filePath),
                'file_path' => $filePath,
                'file_type' => pathinfo($filePath, PATHINFO_EXTENSION),
                'file_size' => Storage::size($filePath) / 1024, // Size in KB
            ])->save();
            
            // dd($upload);
        }
    }
    
    public function success()
    {
        $this->loading = true;
        $this->step = 3;

    }

    public function response()
    {
        $message = $this->userPrompt;

        // Add the new user message to the chat history
        $this->chatHistory[] = ['role' => 'user', 'content' => $message . ' This is current template:' . $this->invoice_template];

        // Create the OpenAI client with your API key
        $client = OpenAI::client(config('app.open_ai_key'));

        try {
            // System prompt to guide the AI response
            $systemPrompt = "You are a helpful assistant that provides assistance on accounting questions in Lithuania. You are an expert accountant and can answer questions about taxes, compliance, relevant dates, and provide reports to upper management. You generate invoice templates and list any missing questions required to complete an invoice.";

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
                        "template" => ["type" => "string", "description" => "Make html invoice template"],
                        "missing_questions" => ["type" => "array", "items" => ["type" => "string"]],
                        "suggestions" => ["type" => "string"]
                    ],
                    "required" => ["template", "missing_questions", "suggestions"],
                    "additionalProperties" => false
                ]
            ];

            // Call the AI service
            $result = $client->chat()->create([
                'model' => 'gpt-4o-2024-08-06', // Assistant name
                'messages' => $messages,
                'response_format' => [
                    'type' => 'json_schema',
                    'json_schema' => $jsonSchema
                ],
                'max_tokens' => 15000,
            ]);

            // Parse the response
            if (isset($result['choices'][0]['message']['content'])) {
                $aiResponseContent = $result['choices'][0]['message']['content'];
                $aiResponse = json_decode($aiResponseContent, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception('Invalid JSON in AI response: ' . json_last_error_msg());
                }

                // Add the AI response to the chat history
                $this->chatHistory[] = ['role' => 'assistant', 'content' => $aiResponse['missing_questions']];
                
                $this->invoice_template = $aiResponse['template'];
                // Assign the response data directly to the component's property
                $this->aiResponse = [
                    'template' => $aiResponse['template'],
                    'missing_questions' => $aiResponse['missing_questions'],
                    'suggestions' => $aiResponse['suggestions'],
                ];
            } else {
                throw new \Exception('Unexpected response structure');
            }
        } catch (\Exception $e) {
            $this->aiResponse = [
                'error' => 'An error occurred while processing your request.',
                'details' => $e->getMessage(),
            ];
        } finally {
            $this->loading = false;
        }
    }

    public function render()
    {
        return view('livewire.upload');
    }
}
