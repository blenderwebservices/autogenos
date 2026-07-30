<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentModelResource\Pages;
use App\Filament\Resources\EquipmentModelResource\RelationManagers;
use App\Models\EquipmentModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipmentModelResource extends Resource
{
    protected static ?string $model = EquipmentModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Electrogenos';

    public static function canViewAny(): bool
    {
        return in_array(auth()->user()->role, ['admin', 'supervisor']);
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('brand_id')
                    ->relationship('brand', 'name')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('power_kw_min')
                    ->numeric(),
                Forms\Components\TextInput::make('power_kw_max')
                    ->numeric(),
                Forms\Components\TextInput::make('fuel_type'),
                Forms\Components\TextInput::make('application'),
                Forms\Components\TextInput::make('alternator_type'),
                Forms\Components\Textarea::make('engine_specs')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('brand.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('power_kw_min')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('power_kw_max')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fuel_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('application')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alternator_type')
                    ->searchable(),
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
            'index' => Pages\ListEquipmentModels::route('/'),
            'create' => Pages\CreateEquipmentModel::route('/create'),
            'edit' => Pages\EditEquipmentModel::route('/{record}/edit'),
        ];
    }
}
