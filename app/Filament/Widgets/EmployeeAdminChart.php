<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EmployeeAdminChart extends ChartWidget
{
    protected static ?string $heading = 'Employees Chart';
    protected static string $color = 'warning';
    protected Static ?int $sort = 2;

    protected function getData(): array
    {
        
        $data = Trend::model(Employee::class)
        ->between(
            start: now()->startOfMonth(),
            end: now()->endOfMonth(),
        )
        ->perDay()
        ->count();
 
        return [
            'datasets' => [
                [
                    'label' => 'Employees Chart',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
