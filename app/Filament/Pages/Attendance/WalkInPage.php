<?php

namespace App\Filament\Pages\Attendance;

use Filament\Pages\Page;

class WalkInPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.walk-in-page';

    protected static ?string $navigationGroup = 'Attendance Management';
    protected static ?string $navigationLabel = 'Walk In';

    // protected static ?int $navigationSort = 1;

    public function getTitle(): string
    {
        return 'Walk-In';
    }
}
