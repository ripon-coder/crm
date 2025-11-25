<?php

namespace App\Filament\Widgets;

use App\Models\ProjectLead;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProjectStats extends BaseWidget
{
    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        // Calculate total due from project leads
        $totalDue = \DB::table('project_leads')
            ->select(
                'project_leads.id',
                'project_leads.budget',
                \DB::raw('COALESCE(SUM(payments.amount), 0) as total_paid')
            )
            ->leftJoin('payments', function($join) {
                $join->on('payments.payable_id', '=', 'project_leads.id')
                     ->where('payments.payable_type', '=', 'App\\Models\\ProjectLead');
            })
            ->groupBy('project_leads.id', 'project_leads.budget')
            ->get()
            ->sum(function($lead) {
                $due = $lead->budget - $lead->total_paid;
                return $due > 0 ? $due : 0;
            });

        return [
            Stat::make('Total Project Leads', ProjectLead::count())
                ->description('Total number of project leads')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('primary'),

            Stat::make('Total Project Budget', '৳' . number_format(ProjectLead::sum('budget'), 2))
                ->description('Total budget of all project leads')
                ->descriptionIcon('heroicon-m-currency-bangladeshi')
                ->color('success'),

            Stat::make('Total Due (Project Leads)', '৳' . number_format($totalDue, 2))
                ->description('Outstanding payments for project leads')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('warning'),
        ];
    }
}
