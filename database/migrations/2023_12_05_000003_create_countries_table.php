<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 3)->unique();
            $table->string('phone_code', 10);
            $table->string('currency_code', 3)->nullable();
            $table->string('currency_symbol', 10)->nullable();
            $table->string('flag')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['code', 'is_active']);
            $table->index('phone_code');
            $table->index('currency_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
