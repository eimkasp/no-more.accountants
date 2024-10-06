<div x-data="{ step: @entangle('step') }" class="relative mx-auto flex items-start text-base max-md:px-5 h-full">
    <div class="mx-auto">
        <div class="w-full">
            <div class="grid grid-cols-12">

                <!-- Chat Container -->
                <div class="w-full chat-container col-span-12">
                    <div class="mb-6" x-show="step > 0">
                        <!-- Suggestions if available -->
                        @if (isset($aiResponse['suggestions']))
                            <div x-data="{ show: false }" class="suggestions bg-gray-700 text-white p-4 rounded-lg mb-4 animate-fade-in">
                                <h2 @click="show = !show" class="text-lg font-bold mb-2">Suggestions</h2>
                                <p x-show="show">{{ $aiResponse['suggestions'] }}</p>
                            </div>
                        @endif
                    </div>

                    {{-- <!-- Headline Section -->
                    <div x-show="step == 0" class="{{ $step == 0 ? 'transition-fade-in' : 'transition-fade-out' }}">
                        <div class="self-center text-5xl font-medium leading-none text-center text-white">
                            <span class="text-lime-400">Create</span> Invoice
                        </div>
                        <div class="self-start mt-4 mr-0 leading-6 text-center text-neutral-200 max-w-3xl mx-auto">
                            Create invoices instantly by typing or speaking to our AI. It fills out all the details
                            and generates a professional template for you!
                        </div>
                    </div> --}}

                    <!-- Chat Log -->
                    @if ($step > 0)
                        <div class="p-9 chat-log {{ $step === 1 ? 'transition-fade-in' : 'transition-fade-out' }}"
                            style="background: rgba(43, 59, 87, 0.7); border-radius: 15px; max-height: 400px; overflow-y: auto;">
                            
                            <div class="flex justify-center items-center mb-4" wire:loading>
                                <div class="loader"></div>
                            </div>

                            @foreach ($chatHistory as $message)
                                @if ($message['role'] == 'user')
                                    <div class="message text-white py-4 rounded mb-6 animate-message">
                                        <div class="text-right">
                                            <p class="bg-blue-500 inline-block p-3 rounded-lg">{{ $message['content'] }}</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-left">
                                        <div class="message text-white py-4 rounded mb-6 animate-message">
                                            <p class="bg-gray-500 inline-block p-3 rounded-lg">{{ is_string($message['content']) ? $message['content'] : '' }}</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            @if (isset($aiResponse['missing_questions']) && count($aiResponse['missing_questions']) > 0)
                                <div class="missing-questions bg-gray-700 text-white p-4 rounded-lg mb-4 animate-fade-in">
                                    <h2 class="text-lg font-bold mb-2">Missing Information</h2>
                                    <ul class="list-disc list-inside">
                                        @foreach ($aiResponse['missing_questions'] as $question)
                                            <li class="mb-2">{{ $question }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (isset($aiResponse['error']))
                                <div class="error-message bg-red-600 text-white p-4 rounded-lg mb-4 animate-fade-in">
                                    <h2 class="text-lg font-bold mb-2">Error</h2>
                                    <p>{{ $aiResponse['error'] }}</p>
                                    <p>{{ $aiResponse['details'] }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- User Input Form -->
                    <form class="flex mt-4" wire:submit.prevent="start">
                        <div class="flex gap-3 items-center w-full">
                            <div class="flex items-center bg-white rounded-full shadow-md w-full px-5 py-3">
                                <input autofocus wire:model.defer="userPrompt" type="text"
                                       class="flex-1 bg-transparent outline-none text-black"
                                       placeholder="Type your request" @keydown.enter.prevent="$wire.start()">
                            </div>
                            <button type="submit"
                                 wire:submit.prevent="start"
                                class="h-full flex items-center justify-center px-4 py-2.5 text-base font-medium leading-none whitespace-nowrap bg-lime-400 hover:bg-lime-500 rounded-full text-slate-800 w-36 transition-colors duration-300">
                                <span wire:loading.remove>Next</span>
                                <span wire:loading>Loading...</span>
                            </button>
                        </div>
                    </form>
                </div>

            
            </div>
        </div>
    </div>

    <!-- Styles and Animations -->
    <style>
        .transition-fade-out { opacity: 0; transform: translateY(-20px); transition: opacity 0.5s ease, transform 0.5s ease; }
        .transition-fade-in { opacity: 1; transform: translateY(0); transition: opacity 0.5s ease, transform 0.5s ease; }
        .chat-log { animation: fadeIn 0.5s ease forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-message { animation: slideIn 0.5s ease forwards; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fadeIn 0.5s ease forwards; }
        .loader { border: 6px solid #f3f3f3; border-top: 6px solid #3498db; border-radius: 50%; width: 36px; height: 36px; animation: spin 1s linear infinite; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</div>
