<?php

namespace App\Providers;

use App\Models\Order;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\UserMembership;

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
                    ->label('Payments'),
                NavigationGroup::make()
                    ->label('Gym Content'),
                NavigationGroup::make()
                    ->label('Reports'),
                NavigationGroup::make()
                    ->label('Account'),
            ]);
        });


        Relation::morphMap([
            'user_memberships' => UserMembership::class,
            'orders' => Order::class,
        ]);
    }
}
