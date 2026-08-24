<?php

namespace App\Filament\Widgets;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
    Stat::make('Total Jobs', Job::count())
        ->description('All jobs in the system')
        ->descriptionIcon('heroicon-m-briefcase')
        ->extraAttributes([
            'class' => 'stat-total-jobs',
        ])
        ->url('/admin/jobs'),

    Stat::make(
        'Open Jobs',
        Job::whereDate('application_deadline', '>=', now())->count()
    )
        ->description('Jobs accepting applications')
        ->descriptionIcon('heroicon-m-check-circle')
        ->extraAttributes([
            'class' => 'stat-open-jobs',
        ])
        ->url('/admin/jobs'),

    Stat::make(
        'Applications',
        JobApplication::where('status', '!=', 'canceled')->count()
    )
        ->description('Total active applications')
        ->descriptionIcon('heroicon-m-document-text')
        ->extraAttributes([
            'class' => 'stat-applications',
        ])
        ->url('/admin/job-applications'),
];
    }
}