<?php

namespace App\Filament\Widgets;

use App\Models\DailyQuiz;
use Filament\Widgets\ChartWidget;

class CategoryDistributionChartWidget extends ChartWidget
{
    protected ?string $heading = 'Stress Category Distribution';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $today = today();
        $last7Days = collect(range(0, 6))->map(fn ($i) => today()->subDays($i));

        // Get data for last 7 days
        $rendah = [];
        $sedang = [];
        $berat = [];

        foreach ($last7Days as $date) {
            $quizzes = DailyQuiz::whereDate('created_at', $date)->get();
            $rendah[] = $quizzes->where('category', 'rendah')->count();
            $sedang[] = $quizzes->where('category', 'sedang')->count();
            $berat[] = $quizzes->where('category', 'berat')->count();
        }

        // Reverse arrays to show oldest to newest
        $rendah = array_reverse($rendah);
        $sedang = array_reverse($sedang);
        $berat = array_reverse($berat);

        $labels = $last7Days->map(fn ($date) => $date->format('M d'))->reverse()->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Rendah (Low)',
                    'data' => $rendah,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.8)', // green
                    'borderColor' => 'rgba(34, 197, 94, 1)',
                ],
                [
                    'label' => 'Sedang (Medium)',
                    'data' => $sedang,
                    'backgroundColor' => 'rgba(251, 191, 36, 0.8)', // yellow/amber
                    'borderColor' => 'rgba(251, 191, 36, 1)',
                ],
                [
                    'label' => 'Berat (High)',
                    'data' => $berat,
                    'backgroundColor' => 'rgba(239, 68, 68, 0.8)', // red
                    'borderColor' => 'rgba(239, 68, 68, 1)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
        ];
    }
}

