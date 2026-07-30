<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ErrorCodeLibraryResource\Pages;
use App\Filament\Resources\ErrorCodeLibraryResource\RelationManagers;
use App\Models\ErrorCodeLibrary;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ErrorCodeLibraryResource extends Resource
{
    protected static ?string $model = ErrorCodeLibrary::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Informacion Tecnica';

    public static function canViewAny(): bool
    {
        return in_array(auth()->user()->role, ['admin', 'supervisor']);
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('brand_id')
                    ->relationship('brand', 'name'),
                Forms\Components\TextInput::make('code')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('possible_causes')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('recommended_actions')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('severity')
                    ->required(),
                Forms\Components\TextInput::make('source'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('brand.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('severity')
                    ->searchable(),
                Tables\Columns\TextColumn::make('source')
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
            'index' => Pages\ListErrorCodeLibraries::route('/'),
            'create' => Pages\CreateErrorCodeLibrary::route('/create'),
            'edit' => Pages\EditErrorCodeLibrary::route('/{record}/edit'),
        ];
    }
}
