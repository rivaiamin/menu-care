<?php

use App\Http\Controllers\JournalController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'quiz.completed'])->name('dashboard');

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

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
