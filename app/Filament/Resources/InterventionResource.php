<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\InterventionResource\Pages;
use App\Models\Intervention;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InterventionResource extends Resource
{
    protected static ?string $model = Intervention::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Intervenciones';
    protected static ?string $modelLabel = 'Intervención';
    protected static ?string $pluralModelLabel = 'Intervenciones';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información General y Equipo')
                    ->description('Asignación y contexto de la orden de servicio en campo.')
                    ->schema([
                        Forms\Components\Select::make('equipment_id')
                            ->relationship('equipment', 'serial_number')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->serial_number} - {$record->asset_code}")
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Equipo / Generador'),
                        Forms\Components\Select::make('technician_id')
                            ->relationship('technician', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Técnico Asignado'),
                        Forms\Components\Select::make('supervisor_id')
                            ->relationship('supervisor', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Supervisor'),
                        Forms\Components\Select::make('type')
                            ->options([
                                'preventive' => 'Mantenimiento Preventivo (250h/500h)',
                                'corrective' => 'Mantenimiento Correctivo / Emergencia',
                                'partial_rebuild' => 'Reconstrucción Parcial (Top End)',
                                'full_rebuild' => 'Reconstrucción Total (Overhaul)',
                            ])
                            ->required()
                            ->label('Tipo de Intervención'),
                        Forms\Components\Select::make('priority')
                            ->options([
                                'low' => 'Baja',
                                'normal' => 'Normal',
                                'high' => 'Alta',
                                'critical' => 'Crítica / Equipo Detenido',
                            ])
                            ->default('normal')
                            ->required()
                            ->label('Prioridad'),
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Borrador / Pendiente',
                                'in_progress' => 'En Progreso / En Campo',
                                'completed' => 'Completada / Para Revisión',
                                'cancelled' => 'Cancelada',
                            ])
                            ->default('in_progress')
                            ->required()
                            ->label('Estado'),
                        Forms\Components\TextInput::make('total_operating_hours')
                            ->numeric()
                            ->label('Horas de Operación del Motor (Horómetro)'),
                    ])->columns(2),

                Forms\Components\Section::make('Diagnóstico e Inteligencia Artificial')
                    ->description('Registro de síntomas, códigos de falla y sugerencias del motor de IA.')
                    ->schema([
                        Forms\Components\Textarea::make('symptoms')
                            ->label('Síntomas Reportados por Cliente / Operador')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\TagsInput::make('error_codes')
                            ->label('Códigos de Error (E-ECU / Controlador)')
                            ->placeholder('Ej: SPN 100 FMI 1, E-042')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('diagnostic_summary')
                            ->label('Resumen Diagnóstico del Técnico')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('preliminary_diagnosis')
                            ->label('Diagnóstico Preliminar')
                            ->rows(2)
                            ->columnSpanFull(),
                        Forms\Components\KeyValue::make('ai_suggestions')
                            ->label('Sugerencias de Inteligencia Artificial (GenTech AI)')
                            ->keyLabel('Parámetro / Sistema')
                            ->valueLabel('Recomendación de Acción')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('ai_confidence')
                            ->numeric()
                            ->suffix('%')
                            ->label('Nivel de Confianza IA'),
                        Forms\Components\Select::make('recommended_action')
                            ->options([
                                'inspect' => 'Inspección Continuada',
                                'repair' => 'Reparación en Sitio',
                                'replace' => 'Reemplazo de Componentes',
                                'rebuild' => 'Envío a Taller para Reconstrucción',
                            ])
                            ->label('Acción Recomendada'),
                    ])->columns(2),

                Forms\Components\Section::make('Checklist de Inspección Técnica')
                    ->description('Verificación sistemática por sistemas del grupo electrógeno.')
                    ->schema([
                        Forms\Components\Repeater::make('checklists')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('section')
                                    ->options([
                                        'engine' => 'Motor de Combustión',
                                        'alternator' => 'Alternador / Generador',
                                        'cooling' => 'Sistema de Enfriamiento / Radiador',
                                        'fuel' => 'Sistema de Combustible / Tanque',
                                        'electrical' => 'Controlador y Sistema Eléctrico',
                                    ])
                                    ->required()
                                    ->label('Sistema / Sección'),
                                Forms\Components\TextInput::make('item_description')
                                    ->required()
                                    ->placeholder('Ej: Nivel y estado de aceite del motor')
                                    ->label('Ítem de Inspección'),
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'ok' => 'OK / Estado Óptimo',
                                        'warning' => 'Advertencia / Requiere Atención',
                                        'critical' => 'Crítico / Falla Detectada',
                                        'not_applicable' => 'No Aplica',
                                    ])
                                    ->default('ok')
                                    ->required()
                                    ->label('Resultado'),
                                Forms\Components\TextInput::make('measurement_value')
                                    ->placeholder('Ej: 4.5, 120, Normal')
                                    ->label('Valor Medido'),
                                Forms\Components\TextInput::make('measurement_unit')
                                    ->placeholder('Ej: bar, °C, V')
                                    ->label('Unidad'),
                                Forms\Components\Textarea::make('observations')
                                    ->rows(1)
                                    ->label('Observaciones / Notas')
                                    ->columnSpanFull(),
                            ])
                            ->columns(3)
                            ->itemLabel(fn (array $state): ?string => $state['item_description'] ?? null)
                            ->collapsible()
                            ->defaultItems(1)
                            ->label('Puntos de Inspección'),
                    ]),

                Forms\Components\Section::make('Repuestos y Componentes Utilizados')
                    ->description('Control de materiales e insumos empleados durante el servicio.')
                    ->schema([
                        Forms\Components\Repeater::make('interventionParts')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('part_id')
                                    ->relationship('part', 'name')
                                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->part_number} - {$record->name}")
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->label('Repuesto / Insumo'),
                                Forms\Components\TextInput::make('quantity')
                                    ->numeric()
                                    ->default(1)
                                    ->required()
                                    ->label('Cantidad'),
                                Forms\Components\TextInput::make('unit_price')
                                    ->numeric()
                                    ->prefix('$')
                                    ->default(0)
                                    ->label('Precio Unit.'),
                                Forms\Components\TextInput::make('discount_percent')
                                    ->numeric()
                                    ->suffix('%')
                                    ->default(0)
                                    ->label('Descuento %'),
                                Forms\Components\TextInput::make('observations')
                                    ->label('Uso / Observación'),
                            ])
                            ->columns(5)
                            ->label('Listado de Repuestos'),
                    ]),

                Forms\Components\Section::make('Tiempos, Costos y Cierre de Intervención')
                    ->schema([
                        Forms\Components\DateTimePicker::make('start_date')
                            ->label('Fecha/Hora de Inicio'),
                        Forms\Components\DateTimePicker::make('completion_date')
                            ->label('Fecha/Hora de Término'),
                        Forms\Components\TextInput::make('actual_duration_minutes')
                            ->numeric()
                            ->label('Duración Real (minutos)'),
                        Forms\Components\TextInput::make('actual_cost')
                            ->numeric()
                            ->prefix('$')
                            ->label('Costo Total de Intervención'),
                        Forms\Components\TextInput::make('technician_signature')
                            ->placeholder('Nombre / Firma Digital del Técnico')
                            ->label('Firma del Técnico Responsable'),
                        Forms\Components\TextInput::make('client_signature')
                            ->placeholder('Nombre / Firma Digital del Cliente')
                            ->label('Firma / Aceptación del Cliente'),
                        Forms\Components\DateTimePicker::make('signed_at')
                            ->label('Fecha de Firma'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('# Orden')
                    ->sortable(),
                Tables\Columns\TextColumn::make('equipment.serial_number')
                    ->label('Nº Serie Equipo')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('technician.name')
                    ->label('Técnico')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->label('Tipo')
                    ->color(fn ($state) => match($state) {
                        'preventive' => 'info',
                        'corrective' => 'warning',
                        'partial_rebuild', 'full_rebuild' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match($state) {
                        'preventive' => 'Preventivo',
                        'corrective' => 'Correctivo',
                        'partial_rebuild' => 'Reconstruc. Parcial',
                        'full_rebuild' => 'Overhaul Total',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('priority')
                    ->badge()
                    ->label('Prioridad')
                    ->color(fn ($state) => match($state) {
                        'low' => 'gray',
                        'normal' => 'success',
                        'high' => 'warning',
                        'critical' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match($state) {
                        'low' => 'Baja',
                        'normal' => 'Normal',
                        'high' => 'Alta',
                        'critical' => 'Crítica',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->label('Estado')
                    ->color(fn ($state) => match($state) {
                        'draft' => 'gray',
                        'in_progress' => 'warning',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match($state) {
                        'draft' => 'Borrador',
                        'in_progress' => 'En Progreso',
                        'completed' => 'Completada',
                        'cancelled' => 'Cancelada',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('total_operating_hours')
                    ->label('Horómetro')
                    ->suffix(' hrs')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Fecha Inicio')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('start_date', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('print_report')
                    ->label('Ver Reporte PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->url(fn (Intervention $record) => route('report.pdf', $record))
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListInterventions::route('/'),
            'create' => Pages\CreateIntervention::route('/create'),
            'edit' => Pages\EditIntervention::route('/{record}/edit'),
        ];
    }
}
