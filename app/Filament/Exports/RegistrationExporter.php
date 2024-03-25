<?php

namespace App\Filament\Exports;

use App\Models\Registration;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class RegistrationExporter extends Exporter
{
    protected static ?string $model = Registration::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id'),
            ExportColumn::make('user.email')
                ->label('Email'),
            ExportColumn::make('user.name')
                ->label('Name'),
            ExportColumn::make('user.nickname')
                ->label('Nickname'),
            ExportColumn::make('user.college.name')
                ->label('School'),
            ExportColumn::make('user.t_shirt_size.name')
                ->label('T-Shirt'),
            ExportColumn::make('user.section.section')
                ->state(function (Registration $registration) {
                    return $registration->user->section->name();
                }),
            ExportColumn::make('user.restrictions')
                ->state(function (Registration $registration) {
                    $restrictions = $registration->user->restrictions;
                    $restrictionList = collect([]);
                    foreach ($restrictions as $restriction) {
                        $allergies = $restriction->allergies;

                        // Push each restriction along with its associated allergies onto the collection
                        $restrictionList->push(
                            $restriction->restriction->name . ($allergies != null ? ": $allergies" : '')
                        );
                    }
                    return $restrictionList->flatten();
                })
                ->label('Restrictions'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your Registration export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
