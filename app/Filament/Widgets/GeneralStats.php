<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Payment;
use App\Models\Vendor;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GeneralStats extends BaseWidget
{
    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        // Calculate total due from dollar sales
        $totalDueDollarSales = \DB::table('dollar_sales')
            ->select(
                'dollar_sales.id',
                'dollar_sales.total_price',
                \DB::raw('COALESCE(SUM(payments.amount), 0) as total_paid')
            )
            ->leftJoin('payments', function($join) {
                $join->on('payments.payable_id', '=', 'dollar_sales.id')
                     ->where('payments.payable_type', '=', 'App\\Models\\DollarSale');
            })
            ->groupBy('dollar_sales.id', 'dollar_sales.total_price')
            ->get()
            ->sum(function($sale) {
                $due = $sale->total_price - $sale->total_paid;
                return $due > 0 ? $due : 0;
            });

        // Calculate today's profit from fully paid sales
        $todaysProfit = \DB::table('dollar_sales')
            ->select('dollar_sales.profit', 'dollar_sales.total_price')
            ->leftJoin('payments', function($join) {
                $join->on('payments.payable_id', '=', 'dollar_sales.id')
                     ->where('payments.payable_type', '=', 'App\\Models\\DollarSale');
            })
            ->whereDate('dollar_sales.created_at', now())
            ->groupBy('dollar_sales.id', 'dollar_sales.profit', 'dollar_sales.total_price')
            ->havingRaw('COALESCE(SUM(payments.amount), 0) >= dollar_sales.total_price')
            ->get()
            ->sum('profit');

        return [
            Stat::make('Today\'s Profit', '৳' . number_format($todaysProfit, 2))
                ->description('Total profit generated today (Fully Paid)')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Total Due (Dollar Sales)', '৳' . number_format($totalDueDollarSales, 2))
                ->description('Outstanding payments for dollar sales')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),

            Stat::make('Total Revenue (Payments)', '৳' . number_format(Payment::sum('amount'), 2))
                ->description('Total payments received')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}
