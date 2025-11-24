<?php

namespace App\Filament\Widgets;

use App\Models\ProjectLead;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProjectStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Project Leads', ProjectLead::count())
                ->description('Total number of project leads')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('primary'),

            Stat::make('Total Project Budget', '৳' . number_format(ProjectLead::sum('budget'), 2))
                ->description('Total budget of all project leads')
                ->descriptionIcon('heroicon-m-currency-bangladeshi')
                ->color('success'),
        ];
    }
}
