<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('our_partners', function (Blueprint $table): void {
            $table->id();
            $table->string('image')->nullable();
            $table->string('link')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('our_partner_translations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('our_partner_id')->constrained('our_partners')->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title');
            $table->timestamps();

            $table->unique(['our_partner_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('our_partner_translations');
        Schema::dropIfExists('our_partners');
    }
};
