<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'quiz.completed'])
    ->name('dashboard');

// Quiz routes
Route::middleware('auth')->group(function () {
    Route::get('quiz', [QuizController::class, 'show'])->name('quiz');
    Route::post('quiz', [QuizController::class, 'store'])->name('quiz.store');
    Route::get('quiz/result', [QuizController::class, 'result'])->name('quiz.result');
    Route::get('api/quiz/status', [QuizController::class, 'status'])->name('quiz.status');
});

// Journal routes
Route::middleware(['auth', 'quiz.completed'])->group(function () {
    Route::resource('journals', JournalController::class);
});

// Progress routes
Route::middleware(['auth', 'quiz.completed'])->group(function () {
    Route::get('api/progress', [DashboardController::class, 'progress'])->name('progress.api');
    Route::get('progress', function () {
        return Inertia::render('Progress');
    })->name('progress');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
