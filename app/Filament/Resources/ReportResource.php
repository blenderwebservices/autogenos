<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\ReportResource\Pages;
use App\Models\Report;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Reportes y Certificados';
    protected static ?string $modelLabel = 'Reporte de Servicio';
    protected static ?string $pluralModelLabel = 'Reportes de Servicio';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detalles del Reporte')
                    ->schema([
                        Forms\Components\Select::make('intervention_id')
                            ->relationship('intervention', 'id')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "Orden #{$record->id} - Equipo: {$record->equipment->serial_number}")
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Orden de Intervención Asignada'),
                        Forms\Components\TextInput::make('report_number')
                            ->required()
                            ->label('Número de Reporte'),
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Borrador',
                                'generated' => 'Generado / PDF Listo',
                                'sent' => 'Enviado a Cliente',
                                'viewed' => 'Visto por Cliente',
                            ])
                            ->default('generated')
                            ->required()
                            ->label('Estado'),
                        Forms\Components\TextInput::make('pdf_url')
                            ->label('URL Archivo PDF / Ruta')
                            ->columnSpanFull(),
                    ])->columns(3),

                Forms\Components\Section::make('Fechas y Validación de Firmas')
                    ->schema([
                        Forms\Components\DateTimePicker::make('generated_at')
                            ->label('Fecha de Generación'),
                        Forms\Components\DateTimePicker::make('sent_at')
                            ->label('Fecha de Envío'),
                        Forms\Components\Toggle::make('technician_signed')
                            ->label('Firmado por Técnico Asignado')
                            ->default(true),
                        Forms\Components\Toggle::make('client_signed')
                            ->label('Aprobado y Firmado por Cliente')
                            ->default(false),
                    ])->columns(2),

                Forms\Components\Section::make('Datos Estructurados del Reporte')
                    ->schema([
                        Forms\Components\KeyValue::make('report_data')
                            ->label('Metadatos y Resumen Ejecutivo')
                            ->keyLabel('Sección / Campo')
                            ->valueLabel('Contenido')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('report_number')
                    ->label('Nº Reporte')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('intervention.id')
                    ->label('Orden #')
                    ->sortable(),
                Tables\Columns\TextColumn::make('intervention.equipment.serial_number')
                    ->label('Equipo / Serie')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->label('Estado')
                    ->color(fn ($state) => match($state) {
                        'draft' => 'gray',
                        'generated' => 'info',
                        'sent' => 'success',
                        'viewed' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match($state) {
                        'draft' => 'Borrador',
                        'generated' => 'PDF Listo',
                        'sent' => 'Enviado',
                        'viewed' => 'Consultado',
                        default => $state,
                    }),
                Tables\Columns\IconColumn::make('technician_signed')
                    ->label('Firma Téc.')
                    ->boolean(),
                Tables\Columns\IconColumn::make('client_signed')
                    ->label('Firma Cli.')
                    ->boolean(),
                Tables\Columns\TextColumn::make('generated_at')
                    ->label('Fecha Generación')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('generated_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('print')
                    ->label('Descargar PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('primary')
                    ->url(fn (Report $record) => route('report.pdf', $record->intervention_id))
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
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
