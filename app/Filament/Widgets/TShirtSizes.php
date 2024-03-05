<?php

namespace App\Filament\Widgets;

use App\Models\TShirtSize;
use Filament\Widgets\ChartWidget;

class TShirtSizes extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        $labels = ['XS', 'S', 'M', 'L', 'XL', '2XL'];
        $tShirtSizes = TShirtSize::withCount('users')->whereIn('name', $labels)->pluck('users_count');

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
}