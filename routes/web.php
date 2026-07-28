<?php

use App\Models\Intervention;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/report/pdf/{intervention}', function (Intervention $intervention) {
    $intervention->load(['equipment.brand', 'equipment.model', 'equipment.client', 'technician', 'supervisor', 'checklists', 'interventionParts.part']);
    
    $pdf = Pdf::loadView('reports.pdf', compact('intervention'));
    
    return $pdf->stream("Reporte-GenTech-INT-{$intervention->id}.pdf");
})->name('report.pdf');
