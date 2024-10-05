<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OpenAiController;
use App\Http\Controllers\PageController;
use App\Http\Livewire\OpenAiInteraction;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/upload', [PageController::class, 'index_upload']);

Route::get('/invoices', [InvoiceController::class, 'index']);

// Route::get('/chat', [OpenAiController::class, 'handle']);



Route::get('/openai', function () {
    return view('openai.index');
})->name('openai.interaction');

Route::post('/openai/handle', [OpenAiController::class, 'handle'])->name('openai.handle');