<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('currencies', static function (Blueprint $table): void {
            $table->id();
            $table->string('code', 3)->unique(); // ISO 4217 Code
            $table->decimal('exchange_rate', 10, 4)->default(1.0000); // Higher precision for exchange rate
            $table->timestamps();
        });

        Schema::create('currency_translations', static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('currency_id')->constrained()->cascadeOnDelete(); // Links to parent currency
            $table->string('locale', 2); // e.g., 'en', 'ar'
            $table->string('name'); // Localized name of the currency
            $table->unique(['currency_id', 'locale']); // Ensures unique translation per locale
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('currency_translations');
        Schema::dropIfExists('currency');
    }
};
