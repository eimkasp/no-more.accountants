<div class="p-6 bg-gray-100 min-h-screen">
    <div class="max-w-lg mx-auto">
        <h1 class="text-2xl font-bold mb-4">OpenAI Interaction</h1>
        
        <form wire:submit.prevent="sendMessage">
            <div class="mb-4">
                <label for="message" class="block text-sm font-medium text-gray-700">Your Prompt</label>
                <textarea wire:model="message" id="message" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
            </div>

            <div class="mb-4">
                <label for="fullHtml" class="block text-sm font-medium text-gray-700">Full HTML (Optional)</label>
                <textarea wire:model="fullHtml" id="fullHtml" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
            </div>

            <div class="mb-4">
                <label for="selectedHtml" class="block text-sm font-medium text-gray-700">Selected HTML (Optional)</label>
                <textarea wire:model="selectedHtml" id="selectedHtml" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
            </div>

            <div class="mb-4">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Send Prompt
                </button>
            </div>
        </form>

        <!-- Display Results -->
        @if ($error)
            <div class="text-red-500">{{ $error }}</div>
        @endif

        @if ($responseHtml)
            <div class="mt-6 bg-white p-4 rounded-md shadow-md">
                <h2 class="text-xl font-bold mb-2">AI Response HTML</h2>
                <pre class="bg-gray-200 p-3 rounded-md overflow-auto">{{ $responseHtml }}</pre>
            </div>

            <div class="mt-6 bg-white p-4 rounded-md shadow-md">
                <h2 class="text-xl font-bold mb-2">Summary</h2>
                <p>{{ $summary }}</p>
            </div>
        @endif
    </div>
</div>
