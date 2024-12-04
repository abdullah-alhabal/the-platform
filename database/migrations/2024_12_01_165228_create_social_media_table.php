<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('social_media', static function (Blueprint $table): void {
            $table->id();
            $table->string('key')->unique();
            $table->string('icon')->nullable();
            $table->string('class')->nullable();
            $table->timestamps();
        });

        Schema::create('social_media_translations', static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('social_media_id')->constrained()->cascadeOnDelete();
            $table->string('locale', 2);
            $table->string('name');
            $table->unique(['social_media_id', 'locale']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_media_translations');
        Schema::dropIfExists('social_media');
    }
};
