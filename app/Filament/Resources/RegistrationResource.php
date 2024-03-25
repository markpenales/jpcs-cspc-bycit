<?php

namespace App\Filament\Resources;

use App\Filament\Exports\RegistrationExporter;
use App\Filament\Resources\RegistrationResource\Pages;
use App\Filament\Resources\RegistrationResource\RelationManagers;
use App\Filament\Resources\RegistrationResource\RelationManagers\UserRelationManager;
use App\Models\Program;
use App\Models\Registration;
use App\Models\Section;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
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
                Select::make('user_id')->relationship('user', 'name'),
                DateTimePicker::make('created_at')->readOnly()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.email')->searchable(),
                TextColumn::make('user.college.name')->searchable(),
                TextColumn::make('user.section.program.code')->label('Program')->searchable(),
                TextColumn::make('user.section.year.name')->searchable(),
                TextColumn::make('user.section.section')->searchable(),
                TextColumn::make('user.nickname')->searchable(),
                ToggleColumn::make('is_paid')->label('Paid'),
            ])
            ->filters([
                SelectFilter::make('college')->relationship('user.college', 'name')->label('School'),
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
            ])
            ->headerActions([
                ExportAction::make()->exporter(RegistrationExporter::class),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            UserRelationManager::class,
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
