<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
        protected function getRedirectUrl(): string
    {
        $status = strtolower($this->record->status);

        $tab = match ($status) {
            'pending' => 'pending',
            'for pickup' => 'for pickup',
            'completed' => 'completed',
            'rejected' => 'rejected',
            default => null,
        };

        $url = $this->getResource()::getUrl('index');

        return $tab ? "{$url}?activeTab={$tab}" : $url;
    }
}
