<?php

namespace App\Filament\Resources\UserMembershipResource\Pages;

use App\Filament\Resources\UserMembershipResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUserMembership extends CreateRecord
{
    protected static string $resource = UserMembershipResource::class;
    
}
