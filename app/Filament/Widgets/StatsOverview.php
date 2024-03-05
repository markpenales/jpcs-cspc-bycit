<?php

namespace App\Filament\Widgets;

use App\Models\Registration;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Users', User::all()->count()),
            Stat::make('Registrations', Registration::all()->count()),
            Stat::make('Registrations from other schools', function () {
                return Registration::whereHas('user',function($subQuery){
                    $subQuery->where('college_id', '!=' , '1');
                })->count();
            }),
        ];
    }
}