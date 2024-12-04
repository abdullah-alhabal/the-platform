<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('visitor_message_replies', static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('message_id')->constrained('visitor_messages')->cascadeOnDelete();
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();
            $table->text('content');
            $table->timestamps();
        });

        Schema::create('visitor_message_reply_translations', static function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('visitor_message_reply_id');
            $table->string('locale')->index();
            $table->text('text');
            $table->timestamps();

            $table->foreign('visitor_message_reply_id')->references('id')->on('visitor_message_replies')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_message_reply_translations');
        Schema::dropIfExists('visitor_message_replies');
    }
};
