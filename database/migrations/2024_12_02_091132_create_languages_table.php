<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('languages', static function (Blueprint $table): void {
            $table->id();
            $table->string('title', 255);
            $table->string('lang', 50)->unique();
            $table->boolean('is_default')->default(false);
            $table->boolean('is_rtl')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('can_delete')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('language_translations', static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->string('locale', 2);
            $table->string('title');
            $table->timestamps();
            $table->unique(['language_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('language_translations');
        Schema::dropIfExists('languages');
    }
};
