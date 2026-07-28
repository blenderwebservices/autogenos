<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('company_id')->nullable()->constrained('companies')->nullOnDelete();
            
            // Identificación
            $table->foreignId('brand_id')->nullable()->constrained('equipment_brands')->nullOnDelete();
            $table->foreignId('model_id')->nullable()->constrained('equipment_models')->nullOnDelete();
            $table->string('serial_number', 100)->unique()->nullable();
            $table->string('asset_code', 100)->nullable();
            
            // Datos específicos
            $table->decimal('rated_power_kw', 10, 2)->nullable();
            $table->string('voltage', 20)->nullable();
            $table->string('frequency', 10)->nullable();
            $table->string('fuel_type', 50)->nullable();
            $table->string('application', 50)->nullable();
            $table->date('installation_date')->nullable();
            
            // Sistema de control
            $table->string('controller_brand', 100)->nullable();
            $table->string('controller_model', 100)->nullable();
            
            // Ubicación
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->text('address')->nullable();
            $table->string('country', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            
            // Estado
            $table->string('status', 50)->default('active'); // active, maintenance, broken, decommissioned
            $table->decimal('total_operating_hours', 12, 2)->default(0);
            $table->date('last_maintenance_date')->nullable();
            $table->date('next_maintenance_date')->nullable();
            $table->integer('maintenance_interval_hours')->default(250);
            
            // Metadata
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index('serial_number');
            $table->index('company_id');
            $table->index(['latitude', 'longitude']);
            $table->index(['brand_id', 'model_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
