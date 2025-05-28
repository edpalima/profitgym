<?php

namespace App\Filament\Pages;

use App\Models\Payment;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RevenueReports extends Page
{
    protected static ?string $navigationGroup = 'Reports';
    protected static string $view = 'filament.pages.revenue-reports';
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public ?string $startDate = null;
    public ?string $endDate = null;

    public array $revenues = [];

    public float $totalRevenue = 0;
    public int $totalTransactions = 0;

    public function mount(): void
    {
        $this->startDate = Carbon::now()->startOfMonth()->toDateString();
        $this->endDate = Carbon::now()->endOfMonth()->toDateString();
        $this->filter();
    }

    public function filter(): void
    {
        $this->generateReport();
        // $this->generateSummaryReport();
    }

    public function generateReport(): void
    {
        $query = Payment::query()
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total_amount')
            ->where('status', 'CONFIRMED');

        if (!empty($this->startDate) && !empty($this->endDate)) {
            $start = Carbon::parse($this->startDate)->startOfDay();
            $end = Carbon::parse($this->endDate)->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
        }

        $dailyRevenues = $query
            ->groupByRaw('DATE(created_at)')
            ->orderByRaw('DATE(created_at)')
            ->get();

        $this->revenues = $dailyRevenues->map(function ($item) {
            return [
                'date' => Carbon::parse($item->date)->toFormattedDateString(),
                'revenue_raw' => (float) $item->total_amount, // keep raw number for calculations
                'revenue' => number_format((float) $item->total_amount, 2), // formatted string for display
            ];
        })->toArray();

        $this->totalRevenue = array_sum(array_column($this->revenues, 'revenue_raw'));
    }

    // public function generateSummaryReport(): void
    // {
    //     $query = Payment::query();

    //     if ($this->startDate && $this->endDate) {
    //         $start = Carbon::parse($this->startDate)->startOfDay();
    //         $end = Carbon::parse($this->endDate)->endOfDay();
    //         $query->whereBetween('created_at', [$start, $end]);
    //     }

    //     $this->totalRevenue = (float) $query->sum('amount');
    //     $this->totalTransactions = (int) $query->count();
    // }

    public function printPdf(): StreamedResponse
    {
        $preparedBy = auth()->user()->name;

        $pdf = Pdf::loadHTML(view('pdfs.revenue-report', [
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'revenues' => $this->revenues,
            'totalRevenue' => $this->totalRevenue,
            'totalTransactions' => $this->totalTransactions,
            'preparedBy' => $preparedBy,
        ])->render());

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'revenue-report.pdf'
        );
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->role === 'ADMIN';
    }
}
