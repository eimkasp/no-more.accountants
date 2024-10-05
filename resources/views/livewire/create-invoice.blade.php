<div class="w-full flex overflow-hidden px-16 text-base bg-slate-800 max-md:px-5 h-full">
    <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/a3584ee97c91245e4f1aff76d5c47ffbe751e27c98600e1d83616fc85d76ed86?placeholderIfAbsent=true&amp;apiKey=5bd982c0b2014e2fb08de87d41f16590" class="absolute top-6 left-6">
    <div class="mx-auto">
        <div class="flex flex-col justify-center items-center px-20 py-48 max-w-full rounded-full border border-dashed border-stone-500 w-[902px] max-md:px-5 max-md:py-24">
            <div class="flex flex-col py-44 mb-0 max-w-full rounded-full border border-dashed border-stone-500 w-[516px] max-md:py-24 max-md:mb-2.5">
                
                <!-- Add transition classes conditionally -->
                <div class="{{ $step == 0 ? 'transition-fade-in' : 'transition-fade-out' }}">
                    <div class="self-center text-5xl font-medium tracking-tighter leading-none text-center text-white">
                        <span class="text-lime-300">Create</span> Invoice
                    </div>
                    <div class="self-start mt-4 mr-0 leading-6 text-center text-neutral-200 max-md:max-w-full">
                        Create invoices instantly by typing or speaking to our AI. It fills out all the details and generates a professional template for you!
                    </div>
                </div>
                <div class="{{ $step > 0 ? 'transition-fade-in' : 'transition-fade-out' }}">

                    @foreach ($chatHistory as $message)
                            <div class="message text-white">
                                 {{  $message }}
                            </div>
                    @endforeach
                </div>
                <div class="chat-container">
                    <form class="flex" wire:submit.prevent="start">
                        <div class="flex gap-3 items-center self-end mt-6 mr-6 mb-0 leading-none text-stone-500 max-md:mr-2.5 max-md:mb-2.5 max-md:max-w-full">
                            <div class="flex gap-2.5 items-start self-stretch my-auto min-h-[52px] min-w-[240px] w-[387px]">
                                <div class="h-full flex gap-3 items-center py-3.5 pr-3 pl-5 bg-white border border-white border-solid min-h-[52px] min-w-[240px] rounded-[38px] shadow-[0px_0px_15px_rgba(0,0,0,0.15)] w-[387px]">
                                    <input wire:model="userPrompt" type="text" class="bg-blend-normal" placeholder="Type your request">
                                    <div class="">
                                    </div>
                                </div>
                                <input type="submit" value="Next " class="flex gap-2.5 items-center px-4 py-2.5 text-base font-medium leading-none whitespace-nowrap bg-lime-400 rounded-lg text-slate-800 flex flex-col self-stretch my-auto w-36">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/1947e73770c809b9eefb31d21e4a9ec39e1bbd6ef8b1b516dd63a052ae3319dd?placeholderIfAbsent=true&amp;apiKey=5bd982c0b2014e2fb08de87d41f16590" class="object-contain shrink-0 self-stretch my-auto aspect-square w-[35px]">
        </div>
        <a href="https://buy.stripe.com/28og1X8yra9SbkY6oy" target="_blank" class="gap-2.5 self-start p-2.5 mt-8 font-semibold tracking-wide text-lime-300 rounded-md border border-lime-300 border-solid">
            Pre-order
        </a>
    </div>
    <style>
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
    
        </style>
</div>
