<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Payment;
use App\Models\Vendor;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GeneralStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Customers', Customer::count())
                ->description('Active customers')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('Total Vendors', Vendor::count())
                ->description('Active vendors')
                ->descriptionIcon('heroicon-m-truck')
                ->color('gray'),

            Stat::make('Total Revenue (Payments)', '৳' . number_format(Payment::sum('amount'), 2))
                ->description('Total payments received')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}
