<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Servicio #{{ $intervention->id }} - GenTech Field</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #333333;
            margin: 0;
            padding: 20px;
        }
        .header {
            width: 100%;
            border-bottom: 2px solid #059669;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .logo-title {
            font-size: 22px;
            font-weight: bold;
            color: #059669;
            text-transform: uppercase;
        }
        .subtitle {
            font-size: 13px;
            color: #666666;
        }
        .report-meta {
            text-align: right;
            font-size: 12px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            background-color: #f3f4f6;
            color: #1f2937;
            padding: 6px 10px;
            margin-top: 15px;
            margin-bottom: 10px;
            border-left: 4px solid #059669;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            padding: 8px 10px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        th {
            background-color: #f9fafb;
            font-weight: 600;
            color: #4b5563;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            color: #ffffff;
            display: inline-block;
        }
        .badge-ok { background-color: #10b981; }
        .badge-warn { background-color: #f59e0b; }
        .badge-crit { background-color: #ef4444; }
        .badge-info { background-color: #3b82f6; }
        .ai-box {
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
        }
        .signatures {
            margin-top: 40px;
            width: 100%;
        }
        .signature-line {
            width: 45%;
            border-top: 1px solid #9ca3af;
            text-align: center;
            padding-top: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <table class="header">
        <tr>
            <td>
                <div class="logo-title">GenTech Field</div>
                <div class="subtitle">Plataforma Inteligente para Grupos Electrógenos</div>
            </td>
            <td class="report-meta">
                <strong>REPORTE DE INTERVENCIÓN</strong><br>
                <strong>Orden #:</strong> INT-{{ str_pad($intervention->id, 5, '0', STR_PAD_LEFT) }}<br>
                <strong>Fecha:</strong> {{ $intervention->start_date ? $intervention->start_date->format('d/m/Y H:i') : now()->format('d/m/Y') }}<br>
                <strong>Estado:</strong> {{ strtoupper($intervention->status) }}
            </td>
        </tr>
    </table>

    <div class="section-title">1. Datos del Equipo Electrógeno</div>
    <table>
        <tr>
            <th>Marca / Modelo:</th>
            <td>{{ $intervention->equipment->brand->name ?? 'N/A' }} / {{ $intervention->equipment->model->name ?? 'N/A' }}</td>
            <th>Nº Serie:</th>
            <td><strong>{{ $intervention->equipment->serial_number }}</strong></td>
        </tr>
        <tr>
            <th>Cliente:</th>
            <td>{{ $intervention->equipment->client->name ?? 'Cliente General' }}</td>
            <th>Horómetro:</th>
            <td>{{ $intervention->total_operating_hours ?? $intervention->equipment->total_operating_hours }} hrs</td>
        </tr>
        <tr>
            <th>Ubicación / Sitio:</th>
            <td colspan="3">{{ $intervention->equipment->address ?? 'En sitio del cliente' }}</td>
        </tr>
    </table>

    <div class="section-title">2. Personal Técnico Asignado</div>
    <table>
        <tr>
            <th>Técnico Responsable:</th>
            <td>{{ $intervention->technician->name ?? 'Técnico Asignado' }}</td>
            <th>Supervisor:</th>
            <td>{{ $intervention->supervisor->name ?? 'Supervisor General' }}</td>
        </tr>
        <tr>
            <th>Tipo de Servicio:</th>
            <td>{{ strtoupper($intervention->type) }}</td>
            <th>Prioridad:</th>
            <td>{{ strtoupper($intervention->priority) }}</td>
        </tr>
    </table>

    <div class="section-title">3. Diagnóstico e Inteligencia Artificial (GenTech AI)</div>
    <table>
        <tr>
            <th width="25%">Síntomas Reportados:</th>
            <td>{{ $intervention->symptoms ?: 'Ninguno registrado' }}</td>
        </tr>
        <tr>
            <th>Códigos de Error (ECU):</th>
            <td>
                @if($intervention->error_codes && is_array($intervention->error_codes))
                    {{ implode(', ', $intervention->error_codes) }}
                @else
                    Sin códigos activos
                @endif
            </td>
        </tr>
        <tr>
            <th>Diagnóstico Técnico:</th>
            <td>{{ $intervention->preliminary_diagnosis ?: ($intervention->diagnostic_summary ?: 'Inspección de rutina') }}</td>
        </tr>
    </table>

    @if($intervention->ai_suggestions && is_array($intervention->ai_suggestions))
    <div class="ai-box">
        <strong style="color: #047857;">💡 Recomendaciones GenTech AI (Confianza: {{ $intervention->ai_confidence ?? 95 }}%):</strong>
        <ul style="margin: 5px 0 0 0; padding-left: 20px;">
            @foreach($intervention->ai_suggestions as $sys => $rec)
                <li><strong>{{ $sys }}:</strong> {{ $rec }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="section-title">4. Checklist de Inspección</div>
    <table>
        <thead>
            <tr>
                <th width="25%">Sistema / Sección</th>
                <th width="40%">Ítem de Inspección</th>
                <th width="15%">Resultado</th>
                <th width="20%">Medición / Notas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($intervention->checklists as $item)
            <tr>
                <td>{{ strtoupper($item->section) }}</td>
                <td>{{ $item->item_description }}</td>
                <td>
                    @if($item->status === 'ok')
                        <span class="badge badge-ok">OK</span>
                    @elseif($item->status === 'warning')
                        <span class="badge badge-warn">ADVERTENCIA</span>
                    @elseif($item->status === 'critical')
                        <span class="badge badge-crit">CRÍTICO</span>
                    @else
                        <span class="badge badge-info">N/A</span>
                    @endif
                </td>
                <td>{{ $item->measurement_value }} {{ $item->measurement_unit }} {{ $item->observations ? '('.$item->observations.')' : '' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; color: #6b7280;">No se registraron ítems específicos en este servicio.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">5. Repuestos Utilizados en la Intervención</div>
    <table>
        <thead>
            <tr>
                <th>Repuesto / Componente</th>
                <th width="15%" style="text-align: center;">Cantidad</th>
                <th width="20%" style="text-align: right;">Precio Unit.</th>
                <th width="20%" style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @php $totalParts = 0; @endphp
            @forelse($intervention->interventionParts as $part)
            @php 
                $subtotal = $part->quantity * $part->unit_price;
                $totalParts += $subtotal;
            @endphp
            <tr>
                <td>{{ $part->part->name ?? 'Repuesto general' }} ({{ $part->part->part_number ?? 'N/A' }})</td>
                <td style="text-align: center;">{{ $part->quantity }}</td>
                <td style="text-align: right;">${{ number_format($part->unit_price, 2) }}</td>
                <td style="text-align: right;">${{ number_format($subtotal, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; color: #6b7280;">No se utilizaron repuestos adicionales.</td>
            </tr>
            @endforelse
            @if($totalParts > 0)
            <tr>
                <th colspan="3" style="text-align: right;">TOTAL REPUESTOS:</th>
                <th style="text-align: right;">${{ number_format($totalParts, 2) }}</th>
            </tr>
            @endif
        </tbody>
    </table>

    <table class="signatures">
        <tr>
            <td class="signature-line" style="float: left;">
                {{ $intervention->technician_signature ?: ($intervention->technician->name ?? 'Técnico Responsable') }}<br>
                <span style="font-size: 10px; font-weight: normal; color: #666;">Firma y Sello del Técnico</span>
            </td>
            <td style="width: 10%;"></td>
            <td class="signature-line" style="float: right;">
                {{ $intervention->client_signature ?: ($intervention->equipment->client->name ?? 'Cliente Propietario') }}<br>
                <span style="font-size: 10px; font-weight: normal; color: #666;">Aceptación y Firma del Cliente</span>
            </td>
        </tr>
    </table>

    <div style="margin-top: 30px; text-align: center; font-size: 10px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 10px;">
        Documento generado automáticamente por el sistema <strong>GenTech Field (Grupos Autógenos)</strong> el {{ now()->format('d/m/Y H:i:s') }}.
    </div>

</body>
</html>
