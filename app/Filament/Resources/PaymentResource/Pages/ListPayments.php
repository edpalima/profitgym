<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\PaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;
use Filament\Resources\Components\Tab;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Builder;
class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
       public function getTabs(): array
    {
        // Get counts for all payment methods
        $paymentCounts = Payment::select('payment_method', DB::raw('count(*) as total'))
            ->groupBy('payment_method')
            ->pluck('total', 'payment_method');

        return [
            'all' => Tab::make('All')
                ->badge(Payment::count()) // Total count of all payments
                ->query(fn(Builder $query) => $query),

            'GCASH' => Tab::make('GCash')
                ->badge($paymentCounts->get('GCASH', 0)) // Count for GCash payments
                ->query(fn(Builder $query) => $query->where('payment_method', 'GCASH')),

            'OVER_THE_COUNTER' => Tab::make('Over the Counter')
                ->badge($paymentCounts->get('OVER_THE_COUNTER', 0)) // Count for Over the Counter payments
                ->query(fn(Builder $query) => $query->where('payment_method', 'OVER_THE_COUNTER')),
        ];
    }
}
