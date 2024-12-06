<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('terms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('taxonomy_id')->constrained('taxonomies')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('terms')->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('meta_keywords')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['taxonomy_id', 'slug']);
            $table->index(['taxonomy_id', 'parent_id', 'is_active']);
            $table->index(['taxonomy_id', 'order']);
        });

        Schema::create('termables', function (Blueprint $table) {
            $table->foreignId('term_id')->constrained()->onDelete('cascade');
            $table->morphs('termable');
            $table->timestamps();

            $table->unique(['term_id', 'termable_id', 'termable_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('termables');
        Schema::dropIfExists('terms');
    }
}; 