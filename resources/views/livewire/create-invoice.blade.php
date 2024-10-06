<div
x-data="{
    step: @entangle('step')
}"
class="mx-auto flex items-start text-base max-md:px-5 h-full">
    <div class="mx-auto">
        <div class="w-full">
            <div class="grid grid-cols-12 gap-6">

                <!-- Chat Container -->
                <div class="w-full chat-container @if ($step == 0) col-span-12 @else col-span-7 @endif">
                    <!-- Show assistant box if step > 0 -->
                   
                        <div class="mb-6" x-show="step > 0">
                            <x-assistant-box></x-assistant-box>
                            <!-- Display Suggestions if Available -->
                            @if(isset($aiResponse['suggestions']))
                                <div 
                                x-data="{
                                    show: false
                                }"
                                class="hidden suggestions bg-gray-700 text-white p-4 rounded-lg mb-4 animate-fade-in">
                                    <h2 @click="show = !show" class="text-lg font-bold mb-2">Suggestions</h2>
                                    <p x-show="show">{{ $aiResponse['suggestions'] }}</p>
                                </div>
                            @endif
                        </div>
                  

                    <!-- Headline Section with Transition -->
                        <div x-show="step == 0" class="{{ $step == 0 ? 'transition-fade-in' : 'transition-fade-out' }}">
                            <div class="self-center text-5xl font-medium leading-none text-center text-white">
                                <span class="text-lime-400">Create</span> Invoice
                            </div>
                            <div class="self-start mt-4 mr-0 leading-6 text-center text-neutral-200 max-w-3xl mx-auto">
                                Create invoices instantly by typing or speaking to our AI. It fills out all the details
                                and generates a professional template for you!
                            </div>
                        </div>

                    <!-- Chat Log -->
                    @if ($step > 0)
                        <div class="p-9 chat-log {{ $step === 1 ? 'transition-fade-in' : 'transition-fade-out' }}"
                            style="background: rgba(43, 59, 87, 0.7); border-radius: 15px; max-height: 400px; overflow-y: auto;">

                            <!-- Loading Spinner -->

                            <div class="flex justify-center items-center mb-4" wire:loading>
                                <div class="loader"></div>
                            </div>


                            <!-- Display Chat History -->
                            @foreach ($chatHistory as $message)
                                {{-- {{ var_dump($message)  }} --}}
                                @if ($message['role'] == 'user')
                                    <div class="message text-white py-4 rounded mb-6 animate-message">
                                        <div class="text-right">
                                            <p class="bg-blue-500 inline-block p-3 rounded-lg">{{ $message['content'] }}
                                            </p>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-left">
                                        <div class="">
                                            @if (is_string($message['content']))
                                                {{-- {{ $message['content'] }} --}}
                                            @elseif(is_array($message['content']))
                                                <div class="message text-white py-4 rounded mb-6 animate-message">

                                                    <ul class="list-disc list-inside">
                                                        @foreach ($message['content'] as $item)
                                                            <li class="mb-2">{{ $item }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            </div>
                                    </div>
                                @endif
                            @endforeach

                            <!-- Display Missing Questions if Available -->
                            @if (isset($aiResponse['missing_questions']) && count($aiResponse['missing_questions']) > 0)
                                <div
                                    class="missing-questions bg-gray-700 text-white p-4 rounded-lg mb-4 animate-fade-in">
                                    <h2 class="text-lg font-bold mb-2">Missing Information</h2>
                                    <ul class="list-disc list-inside">
                                        @foreach ($aiResponse['missing_questions'] as $question)
                                            <li class="mb-2">{{ $question }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif



                            <!-- Display Error if Any -->
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
                                    placeholder="Type your request">
                            </div>
                            <button type="submit"
                                class="h-full flex items-center justify-center px-4 py-2.5 text-base font-medium leading-none whitespace-nowrap bg-lime-400 hover:bg-lime-500 rounded-full text-slate-800 w-36 transition-colors duration-300">

                                <!-- Show "Next" when not loading -->
                                <span wire:loading.remove>Next</span>

                                <!-- Show "Loading..." when loading -->
                                <span wire:loading>Loading...</span>

                            </button>

                        </div>
                    </form>
                    <section class="w-full justify-center flex gap-3 items-center text-sm font-medium tracking-wide text-center text-lime-400">
                        <button class="gap-2.5 self-stretch px-4 py-2.5 my-auto whitespace-nowrap border border-lime-400 border-solid shadow-sm bg-white bg-opacity-10 rounded-[30px] w-[99px]">
                          Hello!
                        </button>
                        <button class="gap-2.5 self-stretch px-4 py-2.5 pr-4 pl-3.5 my-auto border border-lime-400 border-solid shadow-sm bg-white bg-opacity-10 rounded-[30px] w-[178px]">
                          Create a new invoice
                        </button>
                        <button class="gap-2.5 self-stretch px-4 py-2.5 pr-4 pl-3.5 my-auto border border-lime-400 border-solid shadow-sm bg-white bg-opacity-10 rounded-[30px] w-[178px]">
                          Create a new invoice
                        </button>
                      </section>
                </div>

                <!-- Invoice Template -->
                <div
                    class="bg-white top-0 fixed h-full right-[-55px] w-[650px] template-container {{ $step > 0 ? 'transition-fade-in' : 'transition-fade-out' }}">
                    @if (isset($aiResponse['template']))
                        <div class="invoice-template text-black p-4 rounded-lg mb-4 animate-fade-in">
                            <h2 class="text-lg font-bold mb-2">Generated Invoice</h2>
                            <iframe class="scale-[0.8]  origin-top-left	 w-full bg-white min-h-[900px] py-9" srcdoc="{{ $aiResponse['template'] }}">
                            </iframe>
                        </div>
                        <div class="fixed bottom-0 left-0 w-full pl-9">
                            <a class="block mb-6 bg-gray-800 text-white rounded-lg p-4 w-3/4" href="/dashboard">
                                Continue
                            </a>
                        </div>
                    @else
                        <!-- Placeholder when no template is available -->
                        <div class="invoice-placeholder bg-gray-700 text-white rounded-lg mb-4">
                            <h2 class="text-lg font-bold mb-2">Your invoice will appear here.</h2>
                            <p>Once you provide the necessary information, the generated invoice will be displayed.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($step > 0)
    <style>
        #tabs-navigation {
            pointer-events: none;
            opacity: 0;
        }
        #tab-wrapper {
            padding-top: 90px !important;
        }
    </style>
    @endif

    <!-- Styles -->
    <style>
        #tabs-navigation {
            transition: all 1s ease-out;
        }
        #tab-wrapper {
            transition: all 1s ease-out;
        }

        .transition-fade-out {
            opacity: 0;
            transform: translateY(-20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .transition-fade-in {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        /* Chat Log Styling */
        .chat-log {
            animation: fadeIn 0.5s ease forwards;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* New Message Animation */
        .animate-message {
            animation: slideIn 0.5s ease forwards;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Fade-in Animation */
        .animate-fade-in {
            animation: fadeIn 0.5s ease forwards;
        }

        /* Loading Spinner */
        .loader {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #3498db;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Scrollbar Styling */
        .chat-log::-webkit-scrollbar {
            width: 8px;
        }

        .chat-log::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }
    </style>

    <!-- Scripts for Loading Animations -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('message-submitted', event => {
                // Show user message or any UI update
            });

            window.addEventListener('loading-start', event => {
                // Start the loading spinner or animation
                document.getElementById('loading').classList.remove('hidden');
            });

            window.addEventListener('loading-stop', event => {
                // Stop the loading spinner or animation
                document.getElementById('loading').classList.add('hidden');
            });
        });
    </script>
</div>
