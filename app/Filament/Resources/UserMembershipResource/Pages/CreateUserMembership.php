<?php

namespace App\Filament\Resources\UserMembershipResource\Pages;

use App\Filament\Resources\UserMembershipResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUserMembership extends CreateRecord
{
    protected static string $resource = UserMembershipResource::class;
        protected function getRedirectUrl(): string
    {
        $status = strtolower($this->record->status);

        $tab = match ($status) {
            'pending' => 'pending',
            'approved' => 'approved',
            'rejected' => 'rejected',
            default => null,
        };

        $url = $this->getResource()::getUrl('index');

        return $tab ? "{$url}?activeTab={$tab}" : $url;
    }
}
