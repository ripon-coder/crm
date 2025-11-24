<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class DollarSalesTable extends Widget
{
    protected string $view = 'filament.widgets.dollar-sales-table';
    
    protected static ?int $sort = 2;
    
    protected int | string | array $columnSpan = 'full';

    public $selectedYear = null;
    public $selectedMonth = null;

    public function mount(): void
    {
        $this->selectedYear = request()->get('year', 'all');
        $this->selectedMonth = request()->get('month', 'all');
    }

    public function getData(): array
    {
        $query = DB::table('dollar_sales')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total_sales'),
                DB::raw('SUM(profit) as total_profit'),
                DB::raw('SUM(amount) as total_amount')
            );

        if ($this->selectedYear !== 'all') {
            $query->whereYear('created_at', $this->selectedYear);
        }

        if ($this->selectedMonth !== 'all') {
            $query->whereMonth('created_at', $this->selectedMonth);
        }

        return $query
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->orderByRaw('year DESC, month DESC')
            ->get()
            ->toArray();
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
}
