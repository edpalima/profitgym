<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\UserMembership;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {return [
        Stat::make('Total Members', UserMembership::distinct('user_id')->count('user_id'))
            ->description('All registered members')
            ->descriptionIcon('heroicon-m-user-group')
            ->color('success')
            ->url(route('filament.admin.resources.user-memberships.index')),

        Stat::make('Active Memberships', UserMembership::where('status', 'APPROVED')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->count())
            ->description('Currently active')
            ->descriptionIcon('heroicon-m-check-badge')
            ->color('primary')
            ->url(route('filament.admin.resources.user-memberships.index')),

        // Stat::make('Today\'s Attendance', 100)
        //     ->description('Members checked-in today')
        //     ->descriptionIcon('heroicon-m-calendar-days')
        //     ->color('info')
        //     ->url(route('filament.admin.resources.user-memberships.index')),

        Stat::make('Total Products', Product::count())
            ->description('All available products')
            ->descriptionIcon('heroicon-m-cube')
            ->color('warning')
            ->url(route('filament.admin.resources.products.index')),
    ];
    }
}
