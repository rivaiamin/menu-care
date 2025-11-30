<?php

use App\Http\Controllers\ContentController;
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

// Content routes (Mindfulness features)
Route::middleware(['auth', 'quiz.completed'])->group(function () {
    Route::get('api/content/{type}', [ContentController::class, 'index'])->name('content.api');
    Route::get('mindfulness', function () {
        return Inertia::render('mindfulness/Index');
    })->name('mindfulness');
    Route::get('meditation', function () {
        return Inertia::render('mindfulness/Meditation');
    })->name('meditation');
    Route::get('breathing', function () {
        return Inertia::render('mindfulness/Breathing');
    })->name('breathing');
    Route::get('affirmation', function () {
        return Inertia::render('mindfulness/Affirmation');
    })->name('affirmation');
    Route::get('articles', function () {
        return Inertia::render('mindfulness/Articles');
    })->name('articles');
    Route::get('consultation', function () {
        return Inertia::render('Consultation');
    })->name('consultation');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
