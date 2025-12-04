<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Audio;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContentController extends Controller
{
    /**
     * Get content filtered by type, category, and recommended_state.
     *
     * @param  Request  $request
     * @param  string  $type  Content type: 'articles', 'videos', or 'audios'
     * @return JsonResponse
     */
    public function index(Request $request, string $type): JsonResponse
    {
        $user = $request->user();
        $userCategory = $user->latestValidQuiz()?->category ?? 'rendah';
        $contentCategory = $request->query('category'); // 'meditasi', 'relaksasi', 'afirmasi', or null

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
        $query = $model::where(function ($q) use ($userCategory) {
            $q->where('recommended_state', $userCategory)
                ->orWhere('recommended_state', 'semua');
        });

        // Filter by content category if provided (only for videos and audios)
        if ($contentCategory && in_array($contentCategory, ['meditasi', 'relaksasi', 'afirmasi'])) {
            $query->where('category', $contentCategory);
        }

        $content = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'category' => $userCategory,
            'content' => $content,
        ]);
    }

    /**
     * Show a single article.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function showArticle(Request $request, int $id)
    {
        $user = $request->user();
        $userCategory = $user->latestValidQuiz()?->category ?? 'rendah';

        $article = Article::where(function ($q) use ($userCategory) {
            $q->where('recommended_state', $userCategory)
                ->orWhere('recommended_state', 'semua');
        })->findOrFail($id);

        return Inertia::render('mindfulness/ArticleDetail', [
            'article' => $article,
            'category' => $userCategory,
        ]);
    }
}

