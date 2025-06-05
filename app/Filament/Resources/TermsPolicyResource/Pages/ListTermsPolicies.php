<?php

namespace App\Filament\Resources\TermsPolicyResource\Pages;

use App\Filament\Resources\TermsPolicyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTermsPolicies extends ListRecords
{
    protected static string $resource = TermsPolicyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
