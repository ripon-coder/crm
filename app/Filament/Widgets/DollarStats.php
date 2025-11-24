<?php

namespace App\Filament\Widgets;

use App\Models\DollarBatch;
use App\Models\DollarRequest;
use App\Models\DollarSale;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DollarStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Dollar Sales', DollarSale::has('payments')->count())
                ->description('Total number of dollar sales')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('warning'),

            Stat::make('Active Dollar Batches', DollarBatch::where('remaining_amount', '>', 0)->count())
                ->description('Batches with remaining stock')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('primary'),

            Stat::make('Pending Purchase Requests', DollarRequest::where('status', 'pending')->count())
                ->description('Purchase requests awaiting approval')
                ->descriptionIcon('heroicon-m-clock')
                ->color('danger'),

            Stat::make('Total Dollar Profit', '৳' . number_format(
                DollarSale::whereIn('id', function ($query) {
                    $query->select('payable_id')
                        ->from('payments')
                        ->where('payable_type', DollarSale::class)
                        ->groupBy('payable_id')
                        ->havingRaw('SUM(amount) >= (SELECT total_price FROM dollar_sales WHERE id = payments.payable_id)');
                })->sum('profit'), 2))
                ->description('Profit from fully paid sales')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Total Remaining Dollar', '$' . number_format(DollarBatch::sum('remaining_amount'), 2))
                ->description('Total unsold dollars across all batches')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('info'),

            Stat::make('Total Sold Dollar', '$' . number_format(DollarSale::sum('amount'), 2))
                ->description('Total volume of dollars sold')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('warning'),


        ];
    }
}
