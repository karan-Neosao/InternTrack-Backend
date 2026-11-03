
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('internship_id')
                ->constrained('internships')
                ->cascadeOnDelete();

            $table->string('resume_path')->nullable();
            $table->text('cover_letter')->nullable();

            $table->enum('status', [
                'pending',
                'reviewed',
                'accepted',
                'rejected',
            ])->default('pending');

            $table->timestamp('applied_at')->useCurrent();

            $table->timestamps();

            $table->unique(
                ['student_id', 'internship_id'],
                'unique_student_internship_application'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
