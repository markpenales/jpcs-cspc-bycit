<?php

namespace App\Filament\Resources\RegistrationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserRelationManager extends RelationManager
{
    protected static string $relationship = 'user';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email'),
                TextInput::make('last_name'),
                TextInput::make('first_name'),
                TextInput::make('middle_initial'),
                Select::make('college')->relationship('college', 'name'),
                Select::make('t_shirt_size')->relationship('tShirtSize', 'name'),
                Select::make('section')->relationship('section', 'section')->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->program->code} - {$record->year->name}{$record->section}")->label('Program'),
                TextInput::make('nickname'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('email')
            ->columns([
                Tables\Columns\TextColumn::make('email'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ]);
    }
}
