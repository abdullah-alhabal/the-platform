<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('student_opinions', function (Blueprint $table): void {
            $table->id();
            $table->unsignedTinyInteger('rate')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('student_opinion_translations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('student_opinion_id')->constrained('student_opinions')->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('name');
            $table->text('text')->nullable();
            $table->timestamps();

            $table->unique(['student_opinion_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_opinion_translations');
        Schema::dropIfExists('student_opinions');
    }
};
