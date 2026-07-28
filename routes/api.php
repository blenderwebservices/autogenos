<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EquipmentController;
use App\Http\Controllers\Api\InterventionController;
use App\Http\Controllers\Api\AiDiagnosticController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    Route::get('/equipments', [EquipmentController::class, 'index']);
    
    Route::get('/interventions', [InterventionController::class, 'index']);
    Route::get('/interventions/{id}', [InterventionController::class, 'show']);
    Route::put('/interventions/{id}', [InterventionController::class, 'update']);
    Route::post('/interventions/{id}/ai-diagnostic', [AiDiagnosticController::class, 'generate']);
});
