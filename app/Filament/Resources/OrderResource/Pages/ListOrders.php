<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Order;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        // Get counts for each status
        $statusCounts = Order::select('status')
            ->selectRaw('count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            'all' => Tab::make('All')
                ->badge(Order::count())
                ->query(fn (Builder $query) => $query),

            'pending' => Tab::make('Pending')
                ->badge($statusCounts->get('PENDING', 0))
                ->query(fn (Builder $query) => $query->where('status', 'PENDING')),

            'for pickup' => Tab::make('For Pickup')
                ->badge($statusCounts->get('FOR PICKUP', 0))
                ->query(fn (Builder $query) => $query->where('status', 'FOR PICKUP')),

            'completed' => Tab::make('Completed')
                ->badge($statusCounts->get('COMPLETED', 0))
                ->query(fn (Builder $query) => $query->where('status', 'COMPLETED')),

            'rejected' => Tab::make('Rejected')
                ->badge($statusCounts->get('REJECTED', 0))
                ->query(fn (Builder $query) => $query->where('status', 'REJECTED')),
        ];
    }
}
