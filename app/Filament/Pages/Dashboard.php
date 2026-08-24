<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ApplicationsChart;
use App\Filament\Widgets\StatsOverview;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard';

    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            ApplicationsChart::class,
        ];
    }
}