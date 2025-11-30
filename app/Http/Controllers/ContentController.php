<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Audio;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Get content filtered by type and recommended_state.
     *
     * @param  Request  $request
     * @param  string  $type  Content type: 'articles', 'videos', or 'audios'
     * @return JsonResponse
     */
    public function index(Request $request, string $type): JsonResponse
    {
        $user = $request->user();
        $userCategory = $user->latestValidQuiz()?->category ?? 'rendah';

        // Determine which model to use
        $model = match ($type) {
            'articles' => Article::class,
            'videos' => Video::class,
            'audios' => Audio::class,
            default => null,
        };

        if (! $model) {
            return response()->json(['error' => 'Invalid content type'], 400);
        }

        // Filter by recommended_state: show content matching user's category OR 'semua'
        $content = $model::where('recommended_state', $userCategory)
            ->orWhere('recommended_state', 'semua')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'category' => $userCategory,
            'content' => $content,
        ]);
    }
}

