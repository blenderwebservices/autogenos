<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intervention_id')->constrained('interventions')->cascadeOnDelete();
            $table->string('report_number', 50)->unique();
            
            // Contenido estructurado
            $table->json('report_data')->nullable(); // todo el contenido del reporte
            $table->string('pdf_url', 500)->nullable();
            
            // Estado
            $table->string('status', 50)->default('draft'); // draft, generated, sent, viewed
            $table->timestamp('generated_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            
            // Firmas
            $table->boolean('technician_signed')->default(false);
            $table->boolean('client_signed')->default(false);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
