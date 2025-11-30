<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalUsersWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        $newUsersToday = User::where('role', 'user')
            ->whereDate('created_at', today())
            ->count();

        return [
            Stat::make('Total Users', $totalUsers)
                ->description('Medical workers registered')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),
            Stat::make('Total Admins', $totalAdmins)
                ->description('Admin accounts')
                ->descriptionIcon('heroicon-o-shield-check')
                ->color('success'),
            Stat::make('New Users Today', $newUsersToday)
                ->description('Registered today')
                ->descriptionIcon('heroicon-o-user-plus')
                ->color('info'),
        ];
    }
}

