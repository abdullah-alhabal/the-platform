<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('post_categories', static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('post_categories')->nullOnDelete();
            $table->string('value')->unique();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('post_category_translations', static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('post_category_id')->constrained('post_categories')->cascadeOnDelete();
            $table->string('locale');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['post_category_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_category_translations');
        Schema::dropIfExists('post_categories');
    }
};
