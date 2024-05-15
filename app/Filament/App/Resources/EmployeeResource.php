<?php

namespace App\Filament\App\Resources;


use Filament\Forms;
use App\Models\City;
use Filament\Tables;
use App\Models\State;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Employee;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\App\Resources\EmployeeResource\Pages;
use App\Filament\App\Resources\EmployeeResource\RelationManagers;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
 ->schema(([
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
            ->relationship('department', 
            'name',
            modifyQueryUsing: fn(Builder $query) => $query -> whereBelongsTo(Filament::getTenant())
            )
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
    ]));
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('country.name')
                ->searchable()
                ->sortable(),
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
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infoList(Infolist $infolist): Infolist
    {
    return $infolist
        ->schema([  
            Section::make('Relationship')
                ->schema([
                    TextEntry::make('country.name'),
                    TextEntry::make('state.name'),
                    TextEntry::make('city.name'),
                    TextEntry::make('department.name'),
                ])->columns(2),
            Section::make('name')
                ->schema([
                    TextEntry::make('first_name'),
                    TextEntry::make('middle_name'),
                    TextEntry::make('last_name'),
                ])->columns(3),
            Section::make('Address')
                ->schema([
                    TextEntry::make('address'),
                    TextEntry::make('zip_code'),
                ])->columns(2),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
