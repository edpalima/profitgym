<?php

namespace App\Filament\Resources\WorkoutGuideResource\Pages;

use App\Filament\Resources\WorkoutGuideResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWorkoutGuide extends CreateRecord
{
    protected static string $resource = WorkoutGuideResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
