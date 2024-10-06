<?php

namespace App\Livewire;

use App\Models\UserMessage;
use Livewire\Component;
use OpenAI;
use Illuminate\Support\Facades\Log;

class AiChat extends Component
{
    public $userPrompt = "";
    public $aiResponse = [];
    public $loading = false;
    public $step = 0;
    public $chatHistory = [];
    public $lastMessageId = null; // Add this to track the last message ID

    public $apiKey;
    private $assistantId = 'asst_siWSaSJLicnDwkMFXyVTTPAm';
    private $apiUrl = 'https://api.openai.com/v1';
    public function mount() {
        $this->apiKey = config('app.open_ai_key');
    }
    public function render()
    {
        return view('livewire.ai-chat');
    }

    public function start()
    {
        $this->loading = true;
        $this->step++;

        // Save user message
        $this->saveUserMessage();

        // Trigger response with AI assistant
        $this->response();
    }

    public function response()
    {
        $this->loading = true;

        try {
            // Step 1: Create thread
            $threadId = $this->createThread();
            if (!$threadId) {
                throw new \Exception('Failed to create thread');
            }

            // Step 2: Add message to thread
            $message = end($this->chatHistory)['content'];
            $messageId = $this->addMessageToThread($threadId, $message);
            if (!$messageId) {
                throw new \Exception('Failed to add message to thread');
            }

            // Step 3: Run assistant on thread and poll for completion
            $runId = $this->runAssistantOnThread($threadId);
            if (!$runId) {
                throw new \Exception('Failed to run assistant on thread');
            }

            // Step 4: Retrieve and display response
            $this->retrieveAssistantResponse($threadId, $runId);

        } catch (\Exception $e) {
            $this->aiResponse = [
                'error' => 'An error occurred while processing your request.',
                'details' => $e->getMessage(),
            ];
        } finally {
            $this->loading = false;
        }
    }

    private function saveUserMessage()
    {
        // Save the user message without additional instructions in the chat history
        $saved_message = new UserMessage();
        $saved_message->message = $this->userPrompt;
        $saved_message->role = 'user';
        $saved_message->chat_id = 1;
        $saved_message->save();
    
        // Add the user message to chat history (without the extra instructions)
        $this->chatHistory[] = ['role' => 'user', 'content' => $this->userPrompt];
    
        // Prepare the message with additional instructions, but don't show them in the chat
        $messageToSend = $this->userPrompt . " Ignore previous instructions. Do not use files for now. Provide short and concise advice about the tax system in Lithuania.";
    
        // Add message to thread and handle AI interaction
        $this->addMessageToThread($this->createThread(), $messageToSend);
    
        // Clear the user input after processing
        $this->userPrompt = "";
    }
    
    private function createThread()
    {
        $url = $this->apiUrl . '/threads';
        
        // Send the POST request to create a new thread with no additional tools
        $response = $this->postRequest($url, []);
        
        // Decode the response to extract the thread ID
        $responseData = json_decode($response, true);
        
        // Return only the thread ID
        if (isset($responseData['id'])) {
            Log::info('Created thread ID:', ['id' => $responseData['id']]);
            return $responseData['id'];
        } else {
            throw new \Exception('Failed to create thread: Invalid response structure');
        }
    }
    
    private function addMessageToThread($threadId, $message)
    {
        // Construct the correct URL using only the thread ID
        $url = $this->apiUrl . "/threads/" . urlencode($threadId) . "/messages";
        
        // Log the URL for debugging
        Log::info('Corrected URL for adding message:', ['url' => $url]);
        
        $data = ['role' => 'user', 'content' => $message];
        return $this->postRequest($url, $data);
    }

    private function runAssistantOnThread($threadId)
    {
        $url = $this->apiUrl . "/threads/" . urlencode($threadId) . "/runs";
        $data = ['assistant_id' => $this->assistantId];
    
        // Post request to run assistant on thread
        $response = $this->postRequest($url, $data);
    
        if ($response) {
            $responseData = json_decode($response, true);
            if (isset($responseData['id'])) {
                $runId = $responseData['id']; // Return run ID
                // Poll for completion
                return $this->pollRunCompletion($threadId, $runId);
            } else {
                Log::error("RunAssistant Error: " . json_encode($responseData));
                throw new \Exception("Failed to run assistant on thread. Response: " . json_encode($responseData));
            }
        } else {
            throw new \Exception("Failed to get a valid response while running assistant on thread.");
        }
    }
    
    private function pollRunCompletion($threadId, $runId)
    {
        $url = $this->apiUrl . "/threads/$threadId/runs/$runId";
        $maxAttempts = 10; // Set a limit for polling attempts
        $attempt = 0;
    
        while ($attempt < $maxAttempts) {
            $response = $this->getRequest($url);
            $status = $response['status'] ?? 'queued';
    
            Log::info("Polling run status:", ['status' => $status]);
    
            if ($status === 'completed') {
                return $runId; // Return when completed
            }
    
            if ($status === 'failed') {
                throw new \Exception("Assistant run failed.");
            }
    
            sleep(5); // Wait for 5 seconds before checking again
            $attempt++;
        }
    
        throw new \Exception("Assistant run did not complete within the time limit.");
    }

    // Update to retrieve the message using get_new_content function
    private function retrieveAssistantResponse($threadId, $runId)
    {
        // Get the new content after the run completes
        $newContent = $this->getNewContent($threadId, $this->lastMessageId);

        // If new content is found, process it
        if ($newContent) {
            $this->lastMessageId = $newContent['id']; // Update the last message ID
            $messageContent = $newContent['text'];
            $this->aiResponse['template'] = $messageContent;
            $this->chatHistory[] = ['role' => 'assistant', 'content' => $messageContent];
    
            // Save the AI response in a database (if needed)
            $saved_message = new UserMessage();
            $saved_message->message = $messageContent;
            $saved_message->role = 'assistant';
            $saved_message->chat_id = 1;
            $saved_message->save();
    
            Log::info('Final AI Response:', ['template' => $messageContent]);
        } else {
            throw new \Exception('Failed to retrieve assistant response or no new content.');
        }
    }

    // The new function to fetch the latest content
    private function getNewContent($threadId, $lastMessageId = null)
    {
        $url = $this->apiUrl . "/threads/$threadId/messages";

        $response = $this->getRequest($url);

        if ($response && isset($response['data'])) {
            foreach ($response['data'] as $message) {
                if ($message['role'] === "assistant" && (!$lastMessageId || $message['id'] !== $lastMessageId)) {
                    return [
                        'id' => $message['id'],
                        'text' => $message['content'][0]['text']['value']
                    ];
                }
            }
        }

        return null;
    }

    private function postRequest($url, $data)
    {   
        Log::info('POST API Key:' . $this->apiKey);
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey,
            'OpenAI-Beta: assistants=v1',
        ];
    
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        
        $response = curl_exec($curl);
        $error = curl_error($curl);
        $httpCode = (int)curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
    
        // Log the URL, HTTP code, response, and any cURL error
        Log::info('cURL Request to URL:', ['url' => $url]);
        
        Log::info('HTTP Code:', ['httpCode' => $httpCode]);
    
        if ($error) {
            Log::error('cURL Error:', ['error' => $error]);
            throw new \Exception('cURL Error: ' . $error);
        }
    
        if ($httpCode !== 200 && $httpCode !== 201) {
            Log::error('API Request failed with HTTP Code:', ['httpCode' => $httpCode, 'response' => $response]);
            throw new \Exception("API Request failed with HTTP Code $httpCode. Response: $response");
        }
    
        return $response;
    }

    private function getRequest($url)
    {
        Log::info('GET API Key:' . $this->apiKey);
        $headers = [
            'Authorization: Bearer ' . $this->apiKey,
            'OpenAI-Beta: assistants=v1',
        ];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        if ($error) {
            throw new \Exception('cURL Error: ' . $error);
        }

        return json_decode($response, true);
    }
}
