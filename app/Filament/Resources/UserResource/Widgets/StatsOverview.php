<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\Event;
use App\Models\Service;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [

            Stat::make('User', User::count()),
            Stat::make('Event', Event::count()),
            Stat::make('Service', Service::count()),
        ];
    }
}
