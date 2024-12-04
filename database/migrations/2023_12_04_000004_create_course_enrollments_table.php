<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->decimal('paid_amount', 10, 2);
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->default('pending');
            $table->timestamp('enrolled_at');
            $table->timestamp('expires_at')->nullable();
            $table->string('status')->default('active'); // active, completed, expired
            $table->decimal('progress_percentage', 5, 2)->default(0);
            $table->timestamp('last_accessed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Track lesson completion
        Schema::create('lesson_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_enrollment_id')->constrained()->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
            $table->timestamp('completed_at');
            $table->timestamps();

            $table->unique(['course_enrollment_id', 'lesson_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_completions');
        Schema::dropIfExists('course_enrollments');
    }
}; 