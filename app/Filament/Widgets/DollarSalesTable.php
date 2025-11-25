<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class DollarSalesTable extends Widget
{
    protected string $view = 'filament.widgets.dollar-sales-table';
    
    protected static ?int $sort = 2;
    
    protected int | string | array $columnSpan = 'full';
    
    protected ?string $pollingInterval = null;

    public $selectedYear = null;
    public $selectedMonth = null;
    
    public $appliedYear = null;
    public $appliedMonth = null;

    public function mount(): void
    {
        $this->selectedYear = date('Y');
        $this->selectedMonth = 'all';
        $this->appliedYear = date('Y');
        $this->appliedMonth = 'all';
    }

    public function applyFilters(): void
    {
        $this->appliedYear = $this->selectedYear;
        $this->appliedMonth = $this->selectedMonth;
    }

    public function getData(): array
    {
        // Get fully paid and due information for each sale
        $salesWithPaymentInfo = DB::table('dollar_sales')
            ->select(
                'dollar_sales.id',
                'dollar_sales.created_at',
                'dollar_sales.profit',
                'dollar_sales.amount',
                'dollar_sales.total_price',
                DB::raw('COALESCE(SUM(payments.amount), 0) as total_paid'),
                DB::raw('CASE WHEN COALESCE(SUM(payments.amount), 0) >= dollar_sales.total_price THEN 1 ELSE 0 END as is_fully_paid'),
                DB::raw('CASE WHEN COALESCE(SUM(payments.amount), 0) < dollar_sales.total_price THEN dollar_sales.total_price - COALESCE(SUM(payments.amount), 0) ELSE 0 END as due_amount')
            )
            ->leftJoin('payments', function($join) {
                $join->on('payments.payable_id', '=', 'dollar_sales.id')
                     ->where('payments.payable_type', '=', 'App\\Models\\DollarSale');
            })
            ->groupBy('dollar_sales.id', 'dollar_sales.created_at', 'dollar_sales.profit', 'dollar_sales.amount', 'dollar_sales.total_price');

        // Apply year filter if set
        if ($this->appliedYear !== 'all') {
            $salesWithPaymentInfo->whereYear('dollar_sales.created_at', $this->appliedYear);
        }

        // Apply month filter if set
        if ($this->appliedMonth !== 'all') {
            $salesWithPaymentInfo->whereMonth('dollar_sales.created_at', $this->appliedMonth);
        }

        // Get the sales data
        $sales = $salesWithPaymentInfo->get();

        // Group by year and month
        $grouped = $sales->groupBy(function($sale) {
            return date('Y', strtotime($sale->created_at)) . '-' . date('m', strtotime($sale->created_at));
        });

        $result = [];
        foreach ($grouped as $key => $items) {
            list($year, $month) = explode('-', $key);
            
            $fullyPaid = $items->where('is_fully_paid', 1);
            $withDue = $items->where('is_fully_paid', 0);
            
            $result[] = (object)[
                'year' => (int)$year,
                'month' => (int)$month,
                'total_sales' => $items->count(),
                'fully_paid_count' => $fullyPaid->count(),
                'due_count' => $withDue->count(),
                'total_profit' => $fullyPaid->sum('profit'),
                'total_amount' => $items->sum('amount'),
                'total_due' => $withDue->sum('due_amount'),
            ];
        }

        // Sort by year and month descending
        usort($result, function($a, $b) {
            if ($a->year != $b->year) {
                return $b->year - $a->year;
            }
            return $b->month - $a->month;
        });

        return $result;
    }

    public function getYears(): array
    {
        return DB::table('dollar_sales')
            ->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year', 'year')
            ->toArray();
    }

    public function getColumnSpan(): int | string | array
    {
        return 'full';
    }
}
