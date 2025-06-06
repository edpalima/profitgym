<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Models\UserMembership;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalRevenue = Payment::where('status', 'CONFIRMED')->sum('amount');

        return [
            Stat::make('Total Members', User::where('role', 'MEMBER')->count('role'))
                ->description('All registered members')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success')
                ->url(route('filament.admin.resources.users.index') .'?activeTab=MEMBER'),

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

            Stat::make('Total Revenue', '₱' . number_format($totalRevenue, 2))
                ->description('Total confirmed revenue')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color($totalRevenue > 10000 ? 'success' : 'warning')
                ->extraAttributes(['class' => 'text-lg'])
            // ->url(route('filament.resources.payments.index'))
            ,
        ];
    }
}
