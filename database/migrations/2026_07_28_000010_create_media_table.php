<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intervention_id')->nullable()->constrained('interventions')->nullOnDelete();
            $table->foreignId('equipment_id')->nullable()->constrained('equipment')->nullOnDelete();
            
            $table->string('file_key', 255); // S3/R2 key o local path
            $table->string('file_url', 500)->nullable();
            $table->string('thumbnail_url', 500)->nullable();
            
            $table->string('media_type', 20)->default('photo'); // photo, video, audio
            $table->string('mime_type', 50)->nullable();
            $table->bigInteger('file_size_bytes')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('duration_seconds')->nullable();
            
            // Metadata de captura
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamp('capture_timestamp')->nullable();
            $table->json('device_info')->nullable();
            
            // Descripción
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_watermarked')->default(true);
            
            // Visibilidad
            $table->boolean('is_public')->default(false); // para casos de éxito
            $table->timestamp('uploaded_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
