<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 50)->nullable()->after('email');
            $table->string('role', 50)->default('technician')->after('phone'); // admin, supervisor, technician, client
            $table->foreignId('company_id')->nullable()->after('role')->constrained('companies')->nullOnDelete();
            $table->boolean('is_active')->default(true)->after('company_id');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn(['phone', 'role', 'company_id', 'is_active', 'last_login_at']);
        });
    }
};
