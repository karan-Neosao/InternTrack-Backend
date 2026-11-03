<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internships', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('title');
            $table->text('description');
            $table->text('skills')->nullable();
            $table->string('location')->nullable();

            $table->enum('work_type', [
                'remote',
                'onsite',
                'hybrid'
            ])->default('onsite');

            $table->decimal('stipend', 10, 2)->default(0);
            $table->string('duration')->nullable();
            $table->date('deadline')->nullable();

            $table->enum('status', [
                'active',
                'closed'
            ])->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internships');
    }
};
