@extends('layouts.app')

@section('content')
<div
  class="flex flex-wrap gap-10 justify-between items-center p-5 bg-white rounded-xl border border-sky-100 border-solid"
>
  <div class="flex flex-col self-stretch my-auto w-[235px]">
    <div class="flex gap-6 justify-between items-start w-full">
      <div class="flex flex-col text-black w-[168px]">
        <div class="text-3xl font-semibold">$89,935</div>
        <div class="text-base">Total income</div>
      </div>
      <div
        class="flex gap-2.5 items-start p-2.5 w-11 rounded-xl border border-sky-100 border-solid"
      >
        <img
          loading="lazy"
          src="https://cdn.builder.io/api/v1/image/assets/TEMP/582d3fee362c8c0678314a0496527c0488ab20c3eeb394de21a4e793d660a158?placeholderIfAbsent=true&apiKey=35232203c04e4bd99a93d748ab0f4650"
          class="object-contain w-6 aspect-square"
        />
      </div>
    </div>
    <div class="flex gap-3 items-start mt-3 w-full text-sm text-slate-400">
      <div class="flex gap-2 items-center whitespace-nowrap">
        <img
          loading="lazy"
          src="https://cdn.builder.io/api/v1/image/assets/TEMP/044041bd51f4338f8f4f069d47b0039e1375313acc3c639ddfd6a6831825e5d3?placeholderIfAbsent=true&apiKey=35232203c04e4bd99a93d748ab0f4650"
          class="object-contain shrink-0 self-stretch my-auto w-5 aspect-square"
        />
        <div class="self-stretch my-auto">10.2</div>
      </div>
      <div class="flex-1 shrink basis-0">+1.01% this week</div>
    </div>
  </div>
  <div
    class="shrink-0 self-stretch my-auto w-0 bg-sky-100 border border-sky-100 border-solid h-[113px]"
  ></div>
  <div class="flex flex-col self-stretch my-auto w-[235px]">
    <div class="flex gap-8 justify-between items-start w-full max-w-[234px]">
      <div class="flex flex-col text-black w-[157px]">
        <div class="text-3xl font-semibold">$23,879</div>
        <div class="text-base">Total spending</div>
      </div>
      <div
        class="flex gap-2.5 items-start p-2.5 w-11 rounded-xl border border-sky-100 border-solid"
      >
        <img
          loading="lazy"
          src="https://cdn.builder.io/api/v1/image/assets/TEMP/e6e280c61c08f5a5ada2236c2c770c304aba13384daaf198cdb4035dfc5ae087?placeholderIfAbsent=true&apiKey=35232203c04e4bd99a93d748ab0f4650"
          class="object-contain w-6 aspect-square"
        />
      </div>
    </div>
    <div class="flex gap-3 items-start mt-3 w-full text-sm text-slate-400">
      <div class="flex gap-2 items-center whitespace-nowrap">
        <img
          loading="lazy"
          src="https://cdn.builder.io/api/v1/image/assets/TEMP/044041bd51f4338f8f4f069d47b0039e1375313acc3c639ddfd6a6831825e5d3?placeholderIfAbsent=true&apiKey=35232203c04e4bd99a93d748ab0f4650"
          class="object-contain shrink-0 self-stretch my-auto w-5 aspect-square"
        />
        <div class="self-stretch my-auto">3.1</div>
      </div>
      <div class="flex-1 shrink basis-0">+0.49% this week</div>
    </div>
  </div>
  <div
    class="shrink-0 self-stretch my-auto w-0 bg-sky-100 border border-sky-100 border-solid h-[113px]"
  ></div>
  <div class="flex flex-col self-stretch my-auto w-[235px]">
    <div class="flex gap-3 justify-between items-start w-full">
      <div class="flex flex-col text-black whitespace-nowrap w-[180px]">
        <div class="text-3xl font-semibold">46</div>
        <div class="text-base">Invoices</div>
      </div>
      <div
        class="flex gap-2.5 items-start p-2.5 w-11 rounded-xl border border-sky-100 border-solid"
      >
        <img
          loading="lazy"
          src="https://cdn.builder.io/api/v1/image/assets/TEMP/a2259bc3beef4cddbdc03792bee383b1cc65e23e60864679174b3f05826ef8aa?placeholderIfAbsent=true&apiKey=35232203c04e4bd99a93d748ab0f4650"
          class="object-contain w-6 aspect-square"
        />
      </div>
    </div>
    <div class="flex gap-3 items-start mt-3 w-full text-sm text-slate-400">
      <div class="flex gap-2 items-center whitespace-nowrap">
        <img
          loading="lazy"
          src="https://cdn.builder.io/api/v1/image/assets/TEMP/227bb5435f0476a06936a4c8506ac51aeecf8498ca462355c07762ed25c4f4a3?placeholderIfAbsent=true&apiKey=35232203c04e4bd99a93d748ab0f4650"
          class="object-contain shrink-0 self-stretch my-auto w-5 aspect-square"
        />
        <div class="self-stretch my-auto">2.56</div>
      </div>
      <div class="flex-1 shrink basis-0">-0.91% this week</div>
    </div>
  </div>
</div>
@foreach ($invoices as $invoice)
    <div>{{ $invoice->invoice_number }}</div>
    
@endforeach

@endsection