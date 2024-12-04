<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('statistics', function (Blueprint $table): void {
            $table->id();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('statistic_translations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('statistic_id')->constrained('statistics')->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['statistic_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistic_translations');
        Schema::dropIfExists('statistics');
    }
};
