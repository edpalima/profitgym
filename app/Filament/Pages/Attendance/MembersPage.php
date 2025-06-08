<?php

namespace App\Filament\Pages\Attendance;

use Filament\Pages\Page;

class MembersPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.members';

    protected static ?string $navigationGroup = 'Attendance Management';
    protected static ?string $navigationLabel = 'Members';

    protected static ?int $navigationSort = 1;

    public function getTitle(): string
    {
        return 'Members';
    }
}
