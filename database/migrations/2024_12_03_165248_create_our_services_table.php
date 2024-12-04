<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('our_services', static function (Blueprint $table): void {
            $table->id();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('our_service_translations', static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('our_service_id')->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title', 255);
            $table->longText('text');
            $table->timestamps();
            $table->unique(['our_service_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('our_service_translations');
        Schema::dropIfExists('our_services');
    }
};
