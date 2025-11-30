<?php

namespace App\Http\Middleware;

use App\Models\DailyQuiz;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureQuizCompleted
{
    /**
     * Routes that are allowed even if quiz is expired or not completed.
     * Supports both exact route names and prefixes (e.g., 'profile' matches 'profile.edit', 'profile.update', etc.)
     *
     * @var array<string>
     */
    protected $allowedRoutes = [
        'quiz',
        'profile',
        'logout',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip check for guests
        if (! $request->user()) {
            return $next($request);
        }

        // Skip check for admin users
        if ($request->user()->role === 'admin') {
            return $next($request);
        }

        // Allow access to specific routes
        $routeName = $request->route()?->getName();
        if ($routeName) {
            // Check if route name matches any allowed route exactly
            if (in_array($routeName, $this->allowedRoutes)) {
                return $next($request);
            }

            // Check if route name starts with any allowed route prefix (e.g., 'profile.edit' matches 'profile')
            foreach ($this->allowedRoutes as $allowedRoute) {
                if (str_starts_with($routeName, $allowedRoute . '.')) {
                    return $next($request);
                }
            }
        }

        // Check if user has completed quiz within last 24 hours
        // Uses app timezone from APP_TIMEZONE environment variable
        // The timezone should be set to match the user's timezone (e.g., 'Asia/Jakarta' for WIB)
        $validQuiz = DailyQuiz::where('user_id', $request->user()->id)
            ->where('created_at', '>', now()->subHours(24))
            ->latest('created_at')
            ->first();

        // If no valid quiz found, redirect to quiz page
        if (! $validQuiz) {
            return redirect()->route('quiz');
        }

        return $next($request);
    }
}

