@extends('layouts.app')

@section('content')
<div class="w-full h-full bg-slate-800">
    <div class="flex overflow-hidden flex-col bg-white">
        <div
          class="flex flex-col justify-center items-start px-16 py-6 w-full border-b border-black border-opacity-20 max-md:px-5 max-md:max-w-full"
        >
          <img
            loading="lazy"
            src="https://cdn.builder.io/api/v1/image/assets/TEMP/cce970341c65c82c34cbd870533024a839c9393e09fa1f9c499d402ef377b9ed?placeholderIfAbsent=true&apiKey=5bd982c0b2014e2fb08de87d41f16590"
            class="object-contain max-w-full aspect-[3.73] w-[149px]"
          />
        </div>
        <div class="self-end w-full max-w-[1360px] max-md:max-w-full">
          <div class="flex gap-5 max-md:flex-col">
            <div class="flex flex-col w-[45%] max-md:ml-0 max-md:w-full">
              <div
                class="flex flex-col items-start self-stretch my-auto max-md:mt-10 max-md:max-w-full"
              >
                <div
                  class="text-3xl font-semibold tracking-tighter leading-none text-slate-800"
                >
                  <span class="text-slate-800">Drag & Drop</span>
                  Your Invoices
                </div>
                <div
                  class="self-stretch mt-4 text-base leading-6 text-gray-500 max-md:max-w-full"
                >
                  Quickly upload your invoices by simply dragging and dropping them.
                  Our AI will handle the rest, processing and organizing everything in
                  seconds!
                </div>
                <div
                  class="flex flex-col justify-center items-center px-14 py-16 mt-8 max-w-full rounded-xl border border-dashed border-black border-opacity-30 min-h-[326px] w-[531px] max-md:px-5"
                >
                  <img
                    loading="lazy"
                    src="https://cdn.builder.io/api/v1/image/assets/TEMP/915aa1ae47c0d9439cfdd556c7f153e26ccf638e4515fbb6f407c9b9ba330156?placeholderIfAbsent=true&apiKey=5bd982c0b2014e2fb08de87d41f16590"
                    class="object-contain w-12 aspect-square"
                  />
                  <div class="flex flex-col justify-center items-center mt-6">
                    <div class="flex flex-col justify-center items-center">
                      <div class="text-sm text-slate-800">
                        Select a file or drag and drop here
                      </div>
                      <div class="mt-3 text-xs text-black text-opacity-40">
                        JPG, PNG or PDF, ZIP file
                      </div>
                    </div>
                    <div
                      class="gap-2.5 self-stretch px-4 py-3 mt-6 text-base font-medium bg-white rounded-lg border border-solid border-zinc-800 border-opacity-40 min-h-[45px] text-slate-800"
                    >
                      Select file
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="flex flex-col ml-5 w-[55%] max-md:ml-0 max-md:w-full">
              <div
                class="flex flex-col grow px-20 pt-12 pb-28 w-full bg-slate-800 max-md:px-5 max-md:pb-24 max-md:mt-10 max-md:max-w-full"
              >
                <div
                  class="flex shrink-0 max-w-full rounded-full border border-white border-dashed h-[641px] w-[546px]"
                ></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <style>
        builder-component {
          max-width: none !important;
        }
      </style>
</div>

  
@endsection
