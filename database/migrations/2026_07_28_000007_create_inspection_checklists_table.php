<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspection_checklists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intervention_id')->constrained('interventions')->cascadeOnDelete();
            
            $table->string('section', 100)->nullable(); // engine, alternator, cooling, fuel, electrical
            $table->string('category', 100)->nullable(); // visual, measurement, functional
            $table->string('item_code', 50)->nullable();
            $table->text('item_description')->nullable();
            $table->string('status', 20)->default('ok'); // ok, warning, critical, not_applicable
            $table->string('measurement_value', 100)->nullable();
            $table->string('measurement_unit', 20)->nullable();
            $table->text('observations')->nullable();
            $table->json('photo_ids')->nullable(); // URLs o IDs de fotos
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspection_checklists');
    }
};
