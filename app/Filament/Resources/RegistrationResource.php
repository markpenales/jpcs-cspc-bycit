<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegistrationResource\Pages;
use App\Filament\Resources\RegistrationResource\RelationManagers;
use App\Models\Program;
use App\Models\Registration;
use App\Models\Section;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.email'),
                TextColumn::make('user.college.name'),
                TextColumn::make('user.section.program.code')->label('Program'),
                TextColumn::make('user.section.year.name'),
                TextColumn::make('user.section.section'),
                TextColumn::make('created_at')
            ])
            ->filters([
                SelectFilter::make('user.college.name')->relationship('user.college', 'name'),
                SelectFilter::make('program')->relationship('user.section.program', 'code'),
                SelectFilter::make('year')->relationship('user.section.year', 'name'),
                // TODO:
                SelectFilter::make('section')
                    ->options(function () {
                        $tableFilters = request('tableFilters') ?? null;
                        $programId = $tableFilters['program'] ?? null;
                        $yearName = $tableFilters['year'] ?? null;
                        if ($programId && $yearName) {
                            // Retrieve sections based on the selected program and year
                            $sections = Section::whereHas('year', function ($query) use ($yearName) {
                                $query->where('id', $yearName);
                            })->whereHas('program', function ($query) use ($programId) {
                                $query->where('id', $programId);
                            })->pluck('section', 'id')->toArray();

                            return $sections;
                        }

                        return [];
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegistrations::route('/'),
            'create' => Pages\CreateRegistration::route('/create'),
            'edit' => Pages\EditRegistration::route('/{record}/edit'),
        ];
    }
}
