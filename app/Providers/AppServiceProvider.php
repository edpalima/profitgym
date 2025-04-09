<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label('Membership Management'),
                NavigationGroup::make()
                    ->label('Orders'),
                NavigationGroup::make()
                    ->label('Products'),
                NavigationGroup::make()
                    ->label('Payments '),
                NavigationGroup::make()
                    ->label('Gym Content'),
                NavigationGroup::make()
                    ->label('Account'),
            ]);
        });
    }
}
