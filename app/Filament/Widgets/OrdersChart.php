<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class OrdersChart extends ChartWidget
{
    protected static ?string $heading = 'Orders Per Day by Status';
    protected static ?int $sort = 1;
    protected int|string|array $columnSpan = 'half';

    protected function getData(): array
    {
        $now = Carbon::now();
        $daysInMonth = $now->daysInMonth;
        $statuses = ['PENDING', 'FOR PICKUP', 'COMPLETED', 'REJECTED'];

        $labels = range(1, $daysInMonth);
        $datasets = [];

        foreach ($statuses as $status) {
            // Get count of orders per day for each status
            $orders = Order::selectRaw('DAY(created_at) as day, COUNT(*) as total')
                ->whereYear('created_at', $now->year)
                ->whereMonth('created_at', $now->month)
                ->where('status', $status)
                ->groupBy('day')
                ->pluck('total', 'day')
                ->toArray();

            // Fill missing days with 0
            $dataPoints = [];
            foreach ($labels as $day) {
                $dataPoints[] = $orders[$day] ?? 0;
            }

            $datasets[] = [
                'label' => $status,
                'data' => $dataPoints,
                'borderColor' => $this->getStatusColor($status),
                'backgroundColor' => $this->getStatusColor($status),
                'fill' => false,
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line'; // You can change to 'bar' if preferred
    }

    private function getStatusColor(string $status): string
    {
        return match ($status) {
            'PENDING' => '#facc15',     // yellow
            'FOR PICKUP' => '#38bdf8',  // blue
            'COMPLETED' => '#22c55e',   // green
            'REJECTED' => '#ef4444',    // red
            default => '#a3a3a3',       // gray fallback
        };
    }
}
