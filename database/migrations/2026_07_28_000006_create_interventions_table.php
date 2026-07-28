<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('equipment')->cascadeOnDelete();
            $table->foreignId('technician_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('supervisor_id')->nullable()->constrained('users')->nullOnDelete();
            
            // Tipo y contexto
            $table->string('type', 50); // preventive, corrective, partial_rebuild, full_rebuild
            $table->string('priority', 20)->default('normal'); // low, normal, high, critical
            $table->string('status', 50)->default('draft'); // draft, in_progress, completed, cancelled
            
            // Datos de diagnóstico
            $table->string('engine_model', 100)->nullable();
            $table->string('alternator_model', 100)->nullable();
            $table->decimal('total_operating_hours', 12, 2)->nullable();
            
            // Síntomas y hallazgos
            $table->text('symptoms')->nullable();
            $table->json('error_codes')->nullable(); // Almacenado como JSON en lugar de array de PG
            $table->text('diagnostic_summary')->nullable();
            $table->text('preliminary_diagnosis')->nullable();
            
            // Recomendación IA
            $table->json('ai_suggestions')->nullable();
            $table->decimal('ai_confidence', 5, 2)->nullable(); // 0-100
            
            // Plan de acción
            $table->string('recommended_action', 100)->nullable(); // inspect, repair, replace, rebuild
            $table->integer('estimated_duration_minutes')->nullable();
            $table->decimal('estimated_cost', 15, 2)->nullable();
            
            // Ejecución
            $table->timestamp('start_date')->nullable();
            $table->timestamp('completion_date')->nullable();
            $table->integer('actual_duration_minutes')->nullable();
            $table->decimal('actual_cost', 15, 2)->nullable();
            
            // Firmas
            $table->text('technician_signature')->nullable(); // URL o base64
            $table->text('client_signature')->nullable();
            $table->timestamp('signed_at')->nullable();
            
            // Ubicación
            $table->decimal('location_lat', 10, 8)->nullable();
            $table->decimal('location_lng', 11, 8)->nullable();
            
            // Metadata
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index('equipment_id');
            $table->index('technician_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interventions');
    }
};
