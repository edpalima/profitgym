<?php

namespace App\Filament\Resources\WorkoutGuideResource\Pages;

use App\Filament\Resources\WorkoutGuideResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWorkoutGuides extends ListRecords
{
    protected static string $resource = WorkoutGuideResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
