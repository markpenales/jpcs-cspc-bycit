<?php

namespace App\Filament\Widgets;

use App\Models\Program;
use App\Models\Registration;
use App\Models\User;
use Filament\Widgets\ChartWidget;

class ProgramRegistrationChart extends ChartWidget
{
    protected static ?string $heading = 'Programs';
    protected static ?int $sort = 1;



    protected function getData(): array
    {
        $registrations = Registration::with('user.section.program')
            ->selectRaw('programs.code as program_code, count(registrations.id) as registrations_count')
            ->join('users', 'registrations.user_id', '=', 'users.id')
            ->join('sections', 'users.section_id', '=', 'sections.id')
            ->join('programs', 'sections.program_id', '=', 'programs.id')
            ->groupBy('programs.code')
            ->pluck('registrations_count', 'program_code');

        $datasets = [
            [
                'label' => 'Program Registrations',
                'data' => $registrations->values()->toArray(),
            ],
        ];

        $labels = $registrations->keys()->toArray();

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];

    }

    protected function getType(): string
    {
        return 'bar';
    }
}
