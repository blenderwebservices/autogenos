<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('knowledge_base', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->nullable()->constrained('equipment_brands')->nullOnDelete();
            $table->foreignId('model_id')->nullable()->constrained('equipment_models')->nullOnDelete();
            
            $table->string('category', 50)->default('manual'); // manual, diagram, error_code, procedure, tip
            $table->string('title');
            $table->text('content');
            $table->json('tags')->nullable();
            
            // Extra
            $table->string('language', 5)->default('es');
            $table->integer('version')->default(1);
            $table->boolean('approved')->default(true);
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            
            // Referencias
            $table->string('source', 100)->nullable();
            $table->json('reference_links')->nullable();
            
            // Uso
            $table->integer('views_count')->default(0);
            $table->integer('helpful_count')->default(0);
            
            $table->timestamps();
        });

        Schema::create('error_code_library', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->nullable()->constrained('equipment_brands')->cascadeOnDelete();
            $table->string('code', 50);
            $table->text('description')->nullable();
            $table->json('possible_causes')->nullable();
            $table->json('recommended_actions')->nullable();
            $table->string('severity', 20)->default('medium'); // low, medium, high, critical
            $table->string('source', 100)->nullable();
            $table->timestamps();

            $table->unique(['brand_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('error_code_library');
        Schema::dropIfExists('knowledge_base');
    }
};
