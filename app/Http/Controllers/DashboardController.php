<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display the dashboard (BERANDA).
     */
    public function index(Request $request): Response
    {
        $user = $request->user();
        $latestQuiz = $user->latestValidQuiz();

        return Inertia::render('Dashboard', [
            'latestQuiz' => $latestQuiz ? [
                'score' => $latestQuiz->score,
                'category' => $latestQuiz->category,
                'date' => $latestQuiz->date->format('Y-m-d'),
                'created_at' => $latestQuiz->created_at->format('Y-m-d H:i:s'),
            ] : null,
        ]);
    }

    /**
     * Get progress data for charts (API endpoint).
     */
    public function progress(Request $request): JsonResponse
    {
        $user = $request->user();

        // Get all quizzes ordered by date
        $quizzes = $user->dailyQuizzes()
            ->orderBy('date', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        // Prepare data for charts
        $scoreProgression = $quizzes->map(function ($quiz) {
            return [
                'date' => $quiz->date->format('Y-m-d'),
                'score' => $quiz->score,
            ];
        })->values();

        // Category distribution
        $categoryCounts = [
            'rendah' => $quizzes->where('category', 'rendah')->count(),
            'sedang' => $quizzes->where('category', 'sedang')->count(),
            'berat' => $quizzes->where('category', 'berat')->count(),
        ];

        return response()->json([
            'scoreProgression' => $scoreProgression,
            'categoryDistribution' => $categoryCounts,
        ]);
    }
}
