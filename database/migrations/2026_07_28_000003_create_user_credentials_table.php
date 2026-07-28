<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_credentials', function (Blueprint $table) {
            $table->foreignId('user_id')->primary()->constrained('users')->cascadeOnDelete();
            $table->boolean('biometric_enabled')->default(false);
            $table->string('biometric_type', 50)->nullable(); // face, fingerprint
            $table->string('mfa_secret', 255)->nullable();
            $table->boolean('mfa_enabled')->default(false);
            $table->text('device_fingerprint')->nullable();
            $table->string('fcm_token', 255)->nullable(); // push notifications
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_credentials');
    }
};
