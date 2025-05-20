<?php

namespace App\Filament\Resources\WorkoutGuideResource\Pages;

use App\Filament\Resources\WorkoutGuideResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorkoutGuide extends EditRecord
{
    protected static string $resource = WorkoutGuideResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
