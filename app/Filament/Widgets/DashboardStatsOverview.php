<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Company;
use App\Models\Intervention;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Usuarios', User::count())
                ->description('Usuarios registrados')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            Stat::make('Total Intervenciones', Intervention::count())
                ->description('Intervenciones registradas')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('primary'),
            Stat::make('Total Empresas', Company::count())
                ->description('Empresas registradas')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('warning'),
        ];
    }
}
