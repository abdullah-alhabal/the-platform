<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('visitor_messages', static function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('subject');
            $table->text('message');
            $table->timestamp('read_at')->nullable();

            $table->timestamps();
        });

        Schema::create('visitor_message_translations', static function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('visitor_message_id');
            $table->string('locale')->index(); // e.g., 'en', 'ar', 'fr'
            $table->string('subject');
            $table->text('text');
            $table->timestamps();

            $table->foreign('visitor_message_id')->references('id')->on('visitor_messages')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_message_translations');
        Schema::dropIfExists('visitor_messages');
    }
};
