<?php

namespace App\Filament\Widgets;

use App\Models\UserMembership;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class MembersChart extends ChartWidget
{
    protected static ?string $heading = 'New Members Per Month';
    protected static ?int $sort = 1; // Order on dashboard
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $data = [];

        $months = collect(range(1, 12))->map(function ($month) {
            return Carbon::create()->month($month)->format('M');
        })->toArray();

        $membersPerMonth = UserMembership::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $dataPoints = [];

        foreach (range(1, 12) as $month) {
            $dataPoints[] = $membersPerMonth[$month] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'New Members',
                    'data' => $dataPoints,
                    'backgroundColor' => '#4ade80', // green
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
