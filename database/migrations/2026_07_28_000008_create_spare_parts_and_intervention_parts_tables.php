<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spare_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->string('part_number', 100)->unique();
            $table->string('name');
            $table->string('brand', 100)->nullable();
            $table->json('compatible_models')->nullable(); // marcas/modelos compatibles
            $table->string('category', 100)->nullable();
            $table->decimal('price', 15, 2)->default(0);
            $table->integer('stock_quantity')->default(0);
            $table->integer('min_stock_alert')->default(5);
            $table->json('supplier_info')->nullable();
            $table->string('datasheet_url', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('intervention_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intervention_id')->constrained('interventions')->cascadeOnDelete();
            $table->foreignId('part_id')->constrained('spare_parts')->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 15, 2)->default(0);
            $table->decimal('discount_percent', 5, 2)->default(0);
            $table->text('observations')->nullable();
            $table->timestamps();
            
            $table->unique(['intervention_id', 'part_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('intervention_parts');
        Schema::dropIfExists('spare_parts');
    }
};
