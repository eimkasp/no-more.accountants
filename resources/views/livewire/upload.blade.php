<div class="min-h-screen flex items-start justify-start bg-slate-800">
    <div class="w-full max-w-9xl px-16 text-base max-md:px-5">
        <div class="grid grid-cols-12 gap-6 justify-center">
            <!-- Tab Navigation -->
            <div id="tabs-navigation" class="absolute col-span-12 text-center top-0 pt-[100px] left-0 right-0 mx-auto">
                <nav class="inline-flex text-sm font-medium tracking-wide text-center">
                    <!-- Create Invoice Tab -->
                    <a href="javascript:void(0)" wire:click="setActiveTab('create-invoice')"
                        class="mx-2 px-6 py-3 bg-white shadow-sm rounded-full transition-colors duration-300 {{ $activeTab == 'create-invoice' ? 'bg-lime-400 text-slate-800' : 'bg-zinc-800 text-zinc-400' }}">
                        Create Invoice
                    </a>
                    <!-- Upload Invoice Tab -->
                    <a href="javascript:void(0)" wire:click="setActiveTab('upload')"
                        class="mx-2 px-6 py-3 bg-white shadow-sm rounded-full transition-colors duration-300 {{ $activeTab == 'upload' ? 'bg-lime-400 text-slate-800' : 'bg-zinc-800 text-zinc-400' }}">
                        Drag & Drop Invoice
                    </a>
                </nav>
            </div>

            <!-- Tab Content -->
            <div id="tab-wrapper" class="col-span-12  pt-[190px] flex justify-center">
                @if ($activeTab == 'create-invoice' && $step < 3)
                    <livewire:create-invoice>
                    @elseif ($activeTab == 'upload' && $step < 3)
                        <div class="flex flex-col justify-center items-center text-center">
                            <h1 class="text-5xl font-medium leading-none text-white">
                                <span class="text-lime-400">Drag & Drop</span> Invoice
                            </h1>
                            <p class="mt-4 text-base max-w-4xl leading-6 text-neutral-200">
                                Quickly upload your invoices by simply dragging and dropping them. Our AI will handle
                                the rest, processing and organizing everything in seconds!
                            </p>

                            <!-- File Upload Form -->
                            <form action="{{ route('file.upload') }}" wire:submit.prevent="submit" method="POST"
                                class="dropzone flex flex-row justify-center items-center px-14 py-6 mt-8 max-w-full text-base rounded-xl border-4 border-dashed border-lime-400 !bg-zinc-800 transition-all duration-300 hover:bg-zinc-700 hover:border-lime-500 min-h-[245px] w-[531px] max-md:px-5"
                                id="invoice-dropzone" enctype="multipart/form-data">

                                @csrf <!-- Ensure that you include the CSRF token -->

                                <div class="dz-message flex flex-col justify-center items-center text-center">
                                    <img loading="lazy"
                                        src="https://cdn.builder.io/api/v1/image/assets/TEMP/1926fafffa2d6395daaa3d0ac7bd9a8f69a9d1c4f0d0d2c308ae05972552a77d?placeholderIfAbsent=true&apiKey=35232203c04e4bd99a93d748ab0f4650"
                                        alt="" class="object-contain w-12 aspect-square mb-4" />
                                    <p class="text-white text-lg">Drag and Drop Files Here</p>
                                    <p class="mt-2 text-white text-opacity-60">or click to select JPG, PNG, PDF, ZIP
                                        files
                                    </p>
                                </div>
                            </form>

                            <section class="flex gap-7 items-center">
                                <h2 class="self-stretch my-auto text-base text-white">Coming soon! <br> Import from:</h2>
                                <nav class="flex gap-3 items-center self-stretch my-auto min-w-[240px]">
                                    <a href="#"
                                        class="flex flex-col justify-center items-center self-stretch px-2 py-2.5 my-auto bg-white rounded-lg min-h-[43px] w-[99px]">
                                        <img loading="lazy"
                                            src="https://cdn.builder.io/api/v1/image/assets/TEMP/b9f058533d438e8310593b7e9156ea2912efa47b4ad4a68e42a2d2f61787bc34?placeholderIfAbsent=true&apiKey=35232203c04e4bd99a93d748ab0f4650"
                                            alt="Import option 1" class="object-contain aspect-[3.52] w-[81px]">
                                    </a>
                                    <a href="#"
                                        class="flex flex-col justify-center self-stretch px-2 py-2.5 my-auto bg-white rounded-lg min-h-[43px] w-[121px]">
                                        <img loading="lazy"
                                            src="https://cdn.builder.io/api/v1/image/assets/TEMP/b2fe478a1f82b76a265bb868e122cba545ada70e9ad37b6e437a2202e32eda73?placeholderIfAbsent=true&apiKey=35232203c04e4bd99a93d748ab0f4650"
                                            alt="Import option 2" class="object-contain aspect-[4.57] w-[105px]">
                                    </a>
                                    <a href="#"
                                        class="flex flex-col justify-center self-stretch p-2 my-auto bg-white rounded-lg min-h-[43px] w-[100px]">
                                        <img loading="lazy"
                                            src="https://cdn.builder.io/api/v1/image/assets/TEMP/6f45478d41f59862ac93c43b45ad8c04c1c465bead9208465f54aeb7bbbb36b3?placeholderIfAbsent=true&apiKey=35232203c04e4bd99a93d748ab0f4650"
                                            alt="Import option 3" class="object-contain aspect-[3.12] w-[84px]">
                                    </a>
                                </nav>
                            </section>

                            <a href="#" wire:click="success"
                                class="flex flex-col justify-center self-stretch gap-2.5 p-2.5 mt-8 my-auto mx-auto bg-lime-400 rounded-lg min-h-[43px] w-[100px]">
                                Done
                            </a>
                        </div>
                @endif
                @if ($step === 3)
                    <section class="flex flex-col my-auto mx-auto pt-[100px] max-w-[652px]">
                        <header class="flex flex-col w-full text-center max-md:max-w-full">
                            <div class="flex flex-col w-full max-md:max-w-full">
                                <div
                                    class="flex flex-col items-center px-20 w-full rounded-none max-md:px-5 max-md:max-w-full">
                                    <h1 class="text-5xl font-medium tracking-tighter leading-none text-lime-400">
                                        Success!
                                    </h1>
                                    <p class="mt-7 text-base text-neutral-200 max-md:max-w-full">
                                        Invoices successfully uploaded? Check it in your dashboard.
                                    </p>
                                </div>
                            </div>
                        </header>
                        <a href="/dashboard"
                            class="flex gap-2.5 items-center self-center px-4 py-2.5 mt-8 text-base font-medium bg-lime-400 rounded-lg border border-solid border-zinc-800 border-opacity-40 min-h-[45px] text-slate-800">
                            <span class="self-stretch my-auto">Go to dashboard</span>
                            <img loading="lazy"
                                src="https://cdn.builder.io/api/v1/image/assets/TEMP/2623337238ba80fce976b012396778b4965cc7b3535ed0afe15eaf766f851c6b?placeholderIfAbsent=true&apiKey=35232203c04e4bd99a93d748ab0f4650"
                                class="object-contain shrink-0 self-stretch my-auto aspect-[0.96] w-[26px]"
                                alt="" />
                        </a>
                    </section>
                @endif
            </div>

            <!-- Template Container for the AI-generated invoice -->
            @if (isset($aiResponse['template']))
                <div class="col-span-12">
                    <div class="invoice-template bg-gray-800 text-white p-4 rounded-lg mb-4">
                        <h2 class="text-lg font-bold mb-2">Generated Invoice</h2>
                        <iframe class="w-full bg-white min-h-[600px] py-9" srcdoc="{{ $aiResponse['template'] }}">
                        </iframe>
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>
