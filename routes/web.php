<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CodeReviewController;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
Route::get('/code-review', [CodeReviewController::class, 'index'])->name('code-review');

Route::get('/download-project', function () {
    return Storage::download('generated_project.zip');
})->name('download.project');
