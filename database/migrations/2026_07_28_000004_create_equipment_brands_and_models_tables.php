<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment_brands', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('logo_url', 255)->nullable();
            $table->string('website', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('equipment_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('equipment_brands')->cascadeOnDelete();
            $table->string('name', 200);
            $table->decimal('power_kw_min', 10, 2)->nullable();
            $table->decimal('power_kw_max', 10, 2)->nullable();
            $table->string('fuel_type', 50)->nullable(); // diesel, gas, bi-fuel
            $table->string('application', 50)->nullable(); // standby, prime, continuous
            $table->string('alternator_type', 50)->nullable();
            $table->json('engine_specs')->nullable();
            $table->timestamps();

            $table->unique(['brand_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment_models');
        Schema::dropIfExists('equipment_brands');
    }
};
