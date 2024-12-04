<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('pages', static function (Blueprint $table): void {
            $table->id();
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->boolean('can_delete')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('page_translations', static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('page_id')->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title');
            $table->text('text')->nullable();
            $table->unique(['page_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_translations');
        Schema::dropIfExists('pages');
    }
};
