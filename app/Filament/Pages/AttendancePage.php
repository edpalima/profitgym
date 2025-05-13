<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class AttendancePage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.attendance-page';

    protected static ?string $navigationGroup = 'Membership Management';
    protected static ?string $navigationLabel = 'Attendance';
    
    protected static ?int $navigationSort = 2;
}
