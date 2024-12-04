<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('countries', static function (Blueprint $table): void {
            $table->id();
            $table->string('code', 3)->unique(); // ISO 3166-1 alpha-3
            $table->string('flag_url')->nullable(); // Country flag URL
            $table->foreignId('currency_id')->constrained()->cascadeOnDelete(); // Links to the currencies table
            $table->timestamps();
        });

        Schema::create('country_translations', static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('country_id')->constrained()->cascadeOnDelete(); // Links to the parent country
            $table->string('locale', 2); // Language code (e.g., 'en', 'ar')
            $table->string('name'); // Country name in the given locale
            $table->unique(['country_id', 'locale']); // Ensure unique translations per locale
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('country_translations');
        Schema::dropIfExists('countries');
    }
};
