<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_role')->nullable()->default('guest'); // admin, student, company, guest
            $table->string('ip_address', 45)->index();
            $table->text('user_agent')->nullable();
            $table->string('device')->nullable(); // e.g. Windows • Chrome
            $table->string('url', 1000);
            $table->string('method', 10)->default('GET');
            $table->string('action')->nullable(); // e.g. "Viewed Admin Dashboard"
            $table->timestamps();

            $table->index(['created_at', 'ip_address']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};

