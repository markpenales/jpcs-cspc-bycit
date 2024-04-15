<?php

namespace App\Filament\Widgets;

use App\Models\College;
use App\Models\Program;
use App\Models\TShirtSize;
use Filament\Widgets\ChartWidget;

class CollegeSizes extends ChartWidget
{
    protected static ?string $heading = 'College T-shirt Sizes';
    protected static ?int $sort = 1;


    protected function getData(): array
    {
        $labels = ['XS', 'S', 'M', 'L', 'XL', '2XL'];
        $activeFilter = $this->filter;
        $tShirtSizes = TShirtSize::withCount([
            'users' => function ($query) use ($activeFilter) {
                if ($activeFilter == null || $activeFilter == 0) {
                    return $query;
                };
                $query->where('college_id', $activeFilter);

            }
        ])->whereIn('name', $labels)->pluck('users_count');

        return [
            'datasets' => [
                [
                    'label' => 'T-Shirt Sizes',
                    'data' => $tShirtSizes,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getFilters(): array|null
    {
        $programs = College::pluck('name', 'id')->toArray();
        $programs = ['0' => 'All'] + $programs;
        return $programs;
    }
}
