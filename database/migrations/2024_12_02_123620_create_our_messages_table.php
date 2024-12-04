<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('our_messages', function (Blueprint $table): void {
            $table->id();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('our_message_translations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('our_message_id')->constrained('our_messages')->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['our_message_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('our_message_translations');
        Schema::dropIfExists('our_messages');
    }
};
