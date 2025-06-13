<?php

namespace App\Filament\Resources\UserMembershipResource\Pages;

use App\Filament\Resources\UserMembershipResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Models\UserMembership;

class ListUserMemberships extends ListRecords
{
    protected static string $resource = UserMembershipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('viewAttendance')
                ->label('View Attendance')
                ->url(route('filament.admin.pages.members-page')) // Change to your actual route
                ->icon('heroicon-o-eye')
                ->color('primary'),
        ];
    }
    public function getTabs(): array
    {
        // Get counts for each status
        $statusCounts = UserMembership::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $upgradeCount = UserMembership::where('upgrade', true)->count();

        $paymentColors = [
            'all' => 'secondary',
            'pending' => 'primary',
            'approved' => 'success',
            'rejected' => 'danger',
        ];

        return [
            'all' => Tab::make('All')
                ->label('ALL')
                ->badge(UserMembership::count())
                ->badgeColor($paymentColors['all'])
                ->query(fn(Builder $query) => $query),

            'pending' => Tab::make('Pending')
                ->label('PENDING')
                ->badge($statusCounts->get('PENDING', 0))
                ->badgeColor($paymentColors['pending'])
                ->query(fn(Builder $query) => $query->where('status', 'PENDING')),
            'approved' => Tab::make('Approved')
                ->label('APPROVED')
                ->badge($statusCounts->get('APPROVED', 0))
                ->badgeColor($paymentColors['approved'])
                ->query(fn(Builder $query) => $query->where('status', 'APPROVED')),

            'rejected' => Tab::make('Rejected')
                ->label('REJECTED')
                ->badge($statusCounts->get('REJECTED', 0))
                ->badgeColor($paymentColors['rejected'])
                ->query(fn(Builder $query) => $query->where('status', 'REJECTED')),

            'upgrade' => Tab::make('Upgrade')
                ->label('UPGRADE')
                ->badge($upgradeCount)
                ->badgeColor($paymentColors['pending'])
                ->query(fn(Builder $query) => $query->where('upgrade', true)),
        ];
    }
}
