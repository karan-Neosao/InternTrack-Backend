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
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->string('city', 100)->nullable()->after('ip_address');
            $table->string('region', 100)->nullable()->after('city');
            $table->string('country', 100)->nullable()->after('region');
            $table->string('isp', 150)->nullable()->after('country');
            $table->string('custom_label', 150)->nullable()->after('isp');
        });

        Schema::create('ip_labels', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->unique();
            $table->string('label', 150);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ip_labels');

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropColumn(['city', 'region', 'country', 'isp', 'custom_label']);
        });
    }
};
