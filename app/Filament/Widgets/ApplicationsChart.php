<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class ApplicationsChart extends ChartWidget
{
    protected ?string $heading = 'Applications Overview';

    protected function getData(): array
    {
        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);

            $labels[] = $date->format('D');

            $data[] = \App\Models\JobApplication::whereDate(
                'created_at',
                $date
            )
                ->where('status', '!=', 'canceled')
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Applications',
                    'data' => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}