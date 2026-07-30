<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentResource\Pages;
use App\Models\Equipment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EquipmentResource extends Resource
{
    protected static ?string $model = Equipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    protected static ?string $cluster = \App\Filament\Clusters\Clientes::class;
    protected static ?string $navigationLabel = 'Parque Electrógeno';
    protected static ?string $modelLabel = 'Equipo Electrógeno';
    protected static ?string $pluralModelLabel = 'Equipos Electrógenos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identificación y Asignación')
                    ->schema([
                        Forms\Components\Select::make('client_id')
                            ->relationship('client', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Cliente / Propietario'),
                        Forms\Components\Select::make('company_id')
                            ->relationship('company', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Empresa Responsable'),
                        Forms\Components\Select::make('brand_id')
                            ->relationship('brand', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Marca del Generador'),
                        Forms\Components\Select::make('model_id')
                            ->relationship('model', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Modelo del Generador'),
                        Forms\Components\TextInput::make('serial_number')
                            ->required()
                            ->label('Número de Serie'),
                        Forms\Components\TextInput::make('asset_code')
                            ->label('Código de Activo / ID Interno'),
                    ])->columns(2),

                Forms\Components\Section::make('Especificaciones Técnicas')
                    ->schema([
                        Forms\Components\TextInput::make('rated_power_kw')
                            ->numeric()
                            ->suffix(' kW')
                            ->label('Potencia Nominal'),
                        Forms\Components\TextInput::make('voltage')
                            ->placeholder('Ej: 220/380V')
                            ->label('Voltaje'),
                        Forms\Components\TextInput::make('frequency')
                            ->placeholder('Ej: 50Hz / 60Hz')
                            ->label('Frecuencia'),
                        Forms\Components\Select::make('fuel_type')
                            ->options([
                                'diesel' => 'Diésel',
                                'gas' => 'Gas Natural / GLP',
                                'bifuel' => 'Bi-Combustible',
                            ])
                            ->label('Tipo de Combustible'),
                        Forms\Components\Select::make('application')
                            ->options([
                                'standby' => 'Emergencia (Standby)',
                                'prime' => 'Potencia Principal (Prime)',
                                'continuous' => 'Continuo',
                            ])
                            ->label('Aplicación / Régimen'),
                        Forms\Components\DatePicker::make('installation_date')
                            ->label('Fecha de Instalación'),
                    ])->columns(3),

                Forms\Components\Section::make('Controlador y Estado de Mantenimiento')
                    ->schema([
                        Forms\Components\TextInput::make('controller_brand')
                            ->placeholder('Ej: Deep Sea Electronics, ComAp')
                            ->label('Marca Controlador'),
                        Forms\Components\TextInput::make('controller_model')
                            ->placeholder('Ej: DSE7320, InteliLite')
                            ->label('Modelo Controlador'),
                        Forms\Components\Select::make('status')
                            ->options([
                                'active' => 'Activo / Operativo',
                                'maintenance' => 'En Mantenimiento',
                                'broken' => 'En Falla / Detenido',
                                'decommissioned' => 'Fuera de Servicio',
                            ])
                            ->default('active')
                            ->required()
                            ->label('Estado Operativo'),
                        Forms\Components\TextInput::make('total_operating_hours')
                            ->required()
                            ->numeric()
                            ->suffix(' hrs')
                            ->default(0)
                            ->label('Horas Totales de Operación'),
                        Forms\Components\DatePicker::make('last_maintenance_date')
                            ->label('Último Mantenimiento'),
                        Forms\Components\DatePicker::make('next_maintenance_date')
                            ->label('Próximo Mantenimiento Programado'),
                        Forms\Components\TextInput::make('maintenance_interval_hours')
                            ->required()
                            ->numeric()
                            ->suffix(' hrs')
                            ->default(250)
                            ->label('Intervalo de Mantenimiento'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('asset_code')
                    ->label('ID Activo')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('serial_number')
                    ->label('Nº Serie')
                    ->searchable(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->label('Marca')
                    ->sortable(),
                Tables\Columns\TextColumn::make('model.name')
                    ->label('Modelo')
                    ->sortable(),
                Tables\Columns\TextColumn::make('client.name')
                    ->label('Cliente')
                    ->sortable(),
                Tables\Columns\TextColumn::make('rated_power_kw')
                    ->label('Potencia')
                    ->suffix(' kW')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->label('Estado')
                    ->color(fn ($state) => match($state) {
                        'active' => 'success',
                        'maintenance' => 'warning',
                        'broken' => 'danger',
                        'decommissioned' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match($state) {
                        'active' => 'Operativo',
                        'maintenance' => 'Mantenimiento',
                        'broken' => 'En Falla',
                        'decommissioned' => 'Inactivo',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('total_operating_hours')
                    ->label('Horómetro')
                    ->suffix(' hrs')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('next_maintenance_date')
                    ->label('Próx. Manto.')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->defaultSort('next_maintenance_date', 'asc')
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
            'index' => Pages\ListEquipment::route('/'),
            'create' => Pages\CreateEquipment::route('/create'),
            'edit' => Pages\EditEquipment::route('/{record}/edit'),
        ];
    }
}
