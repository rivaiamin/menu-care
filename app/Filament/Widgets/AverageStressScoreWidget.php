<?php

namespace App\Filament\Widgets;

use App\Models\DailyQuiz;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AverageStressScoreWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $today = today();
        $yesterday = today()->subDay();

        // Today's stats
        $todayQuizzes = DailyQuiz::whereDate('created_at', $today)->get();
        $todayAverage = $todayQuizzes->isNotEmpty()
            ? round($todayQuizzes->avg('score'), 2)
            : 0;
        $todayCount = $todayQuizzes->count();

        // Yesterday's stats for comparison
        $yesterdayQuizzes = DailyQuiz::whereDate('created_at', $yesterday)->get();
        $yesterdayAverage = $yesterdayQuizzes->isNotEmpty()
            ? round($yesterdayQuizzes->avg('score'), 2)
            : 0;

        // Overall average
        $overallAverage = DailyQuiz::avg('score') ?? 0;
        $overallAverage = round($overallAverage, 2);

        // Calculate change percentage
        $change = $yesterdayAverage > 0
            ? round((($todayAverage - $yesterdayAverage) / $yesterdayAverage) * 100, 1)
            : 0;

        return [
            Stat::make('Average Stress Score (Today)', $todayAverage)
                ->description($todayCount . ' quiz' . ($todayCount !== 1 ? 'es' : '') . ' completed today')
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color($todayAverage >= 27 ? 'danger' : ($todayAverage >= 14 ? 'warning' : 'success'))
                ->chart($this->getLast7DaysData()),
            Stat::make('Overall Average Score', $overallAverage)
                ->description('All time average')
                ->descriptionIcon('heroicon-o-academic-cap')
                ->color('primary'),
            Stat::make('Change from Yesterday', $change > 0 ? '+' . $change . '%' : $change . '%')
                ->description($change > 0 ? 'Increased' : ($change < 0 ? 'Decreased' : 'No change'))
                ->descriptionIcon($change > 0 ? 'heroicon-o-arrow-trending-up' : ($change < 0 ? 'heroicon-o-arrow-trending-down' : 'heroicon-o-minus'))
                ->color($change > 0 ? 'danger' : ($change < 0 ? 'success' : 'gray')),
        ];
    }

    protected function getLast7DaysData(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $avg = DailyQuiz::whereDate('created_at', $date)->avg('score') ?? 0;
            $data[] = round($avg, 1);
        }
        return $data;
    }
}

