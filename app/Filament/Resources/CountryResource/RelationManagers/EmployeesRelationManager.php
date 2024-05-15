<?php

namespace App\Filament\Resources\CountryResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use App\Models\City;
use App\Models\State;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class EmployeesRelationManager extends RelationManager
{
    protected static string $relationship = 'employees';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Relationship')
    ->description('put the user name detail in')
    ->schema([
            Forms\Components\Select::make('country_id')
            ->relationship('country', 'name')
            ->searchable()
            ->preload()
            ->afterStateUpdated(function(Set $set){
                $set('state_id', null);
                $set('city_id', null);
            })
            ->live()
            ->required(),
            Forms\Components\Select::make('state_id')
            ->options(fn(Get $get): collection =>State::query()
                ->where('country_id', $get('country_id'))
                ->pluck('name', 'id'))
            ->searchable()
            ->preload()
            ->live()
            ->afterStateUpdated(fn(Set $set)=>$set('city_id', null))
            ->required(),
            Forms\Components\Select::make('city_id')
            ->options(fn(Get $get): collection =>City::query()
                ->where('state_id', $get('state_id'))
                ->pluck('name', 'id'))
            ->searchable()
            ->preload()
            ->live()
            ->required(),
            Forms\Components\Select::make('department_id')
            ->relationship('department', 'name')
            ->searchable()
            ->preload()
            ->required(),
            ])->columns(2),
    Forms\Components\Section::make('User Name')
    ->description('put the user name detail in')
    ->schema([
            Forms\Components\TextInput::make('first_name')
            ->required()
            ->maxLength(255),
            Forms\Components\TextInput::make('middle_name')
            ->required()
            ->maxLength(255),
            Forms\Components\TextInput::make('last_name')
            ->required()
            ->maxLength(255),
            ])->columns(3),
    Forms\Components\Section::make('User Address')
    ->schema([
            Forms\Components\TextInput::make('address')
            ->required()
            ->maxLength(255),
            Forms\Components\TextInput::make('zip_code')
            ->required()
            ->maxLength(255),
            ])->columns(2),
    Forms\Components\Section::make('dates')
    ->schema([
            Forms\Components\DatePicker::make('date_of_birth')
            ->native(false)
            ->displayFormat('d/m/Y')
            ->required(),
            Forms\Components\DatePicker::make('date_hired')
            ->native(false)
            ->displayFormat('d/m/Y')
            ->required()
            ])->columns(2)
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('first_name')
            ->columns([
        Tables\Columns\TextColumn::make('first_name')
            ->searchable()
            ->sortable(),
        Tables\Columns\TextColumn::make('last_name')
            ->searchable(),
        Tables\Columns\TextColumn::make('middle_name')
            ->toggleable(isToggledHiddenByDefault: true)
            ->searchable(),
        Tables\Columns\TextColumn::make('address')
            ->toggleable(isToggledHiddenByDefault: true)
            ->searchable(),
        Tables\Columns\TextColumn::make('zip_code')
            ->searchable(),
        Tables\Columns\TextColumn::make('date_of_birth')
            ->date()
            ->toggleable(isToggledHiddenByDefault: true)
            ->sortable(),
        Tables\Columns\TextColumn::make('date_hired')
            ->date()
            ->sortable(),
        Tables\Columns\TextColumn::make('created_at')
            ->dateTime()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true),
        Tables\Columns\TextColumn::make('updated_at')
            ->dateTime()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    
}
