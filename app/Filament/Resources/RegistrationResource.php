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
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
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
                Filter::make('section')->form([
                    Select::make('program')->relationship('user.section.program', 'code')
                        ->label('Program'),
                    Select::make('year')->relationship('user.section.year', 'name')
                        ->label('Year'),
                    Select::make('section')->options(function (Get $get) {

                        $program = $get('program');
                        $year = $get('year');
                        if (!$program || !$year) {
                            return [];
                        }
                        return Section::where('program_id', $program)->where('year_id', $year)->pluck('section', 'id')->toArray();
                    }),
                ])
                    ->query(
                        fn(Builder $query, array $data) =>
                        empty ($data['section']) ? $query :
                        $query->whereHas(
                            'user',
                            function ($subQuery) use ($data) {
                                $subQuery->where('section_id', $data['section']);
                            }
                        )
                    )
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
