<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Support\Facades\DB;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


    public function getTabs(): array
    {
        // Get counts for each role
        $roleCounts = User::select('role', DB::raw('count(*) as total'))
            ->groupBy('role')
            ->pluck('total', 'role');

        return [
            'all' => Tab::make('All')
                ->badge(User::count())
                ->query(fn(Builder $query) => $query),

            'ADMIN' => Tab::make('ADMIN')
                ->badge($roleCounts->get('ADMIN', 0))
                ->query(fn(Builder $query) => $query->where('role', 'ADMIN')),

            'STAFF' => Tab::make('STAFF')
                ->badge($roleCounts->get('STAFF', 0))
                ->query(fn(Builder $query) => $query->where('role', 'STAFF')),

            'MEMBER' => Tab::make('MEMBER')
                ->badge($roleCounts->get('MEMBER', 0))
                ->query(fn(Builder $query) => $query->where('role', 'MEMBER')),
        ];
    }
}
