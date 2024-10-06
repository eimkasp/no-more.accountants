<?php

use App\Http\Controllers\AskController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OpenAiController;
use App\Http\Controllers\PageController;
use App\Http\Livewire\OpenAiInteraction;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceUploadController;

Route::get('/', function () {
    return view('pages.upload');
});

// Route::get('/upload', [PageController::class, 'index_upload']);

Route::get('/invoices', [InvoiceController::class, 'index']);

// Route::get('/chat', [OpenAiController::class, 'handle']);

Route::get('/upload', function () {
    return view('pages.upload');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard');
});


Route::get('/openai', function () {
    return view('openai.index');
})->name('openai.interaction');

Route::post('/file/upload', [InvoiceUploadController::class, 'upload'])->name('file.upload');


Route::post('/openai/handle', [OpenAiController::class, 'handle'])->name('openai.handle');

Route::get("/ask", [AskController::class, 'index']);