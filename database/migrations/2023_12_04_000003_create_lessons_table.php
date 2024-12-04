<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_section_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('type'); // video, text, live, quiz, etc.
            $table->morphs('lessonable'); // Polymorphic relationship for different lesson types
            $table->integer('duration_minutes')->default(0);
            $table->integer('order')->default(0);
            $table->boolean('is_free')->default(false);
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Video lessons
        Schema::create('video_lessons', function (Blueprint $table) {
            $table->id();
            $table->string('video_url');
            $table->string('video_provider')->default('youtube'); // youtube, vimeo, etc.
            $table->text('transcript')->nullable();
            $table->timestamps();
        });

        // Text lessons
        Schema::create('text_lessons', function (Blueprint $table) {
            $table->id();
            $table->longText('content');
            $table->text('attachments')->nullable();
            $table->timestamps();
        });

        // Live lessons
        Schema::create('live_lessons', function (Blueprint $table) {
            $table->id();
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->string('meeting_url')->nullable();
            $table->string('meeting_password')->nullable();
            $table->string('platform')->default('zoom'); // zoom, meet, etc.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('live_lessons');
        Schema::dropIfExists('text_lessons');
        Schema::dropIfExists('video_lessons');
        Schema::dropIfExists('lessons');
    }
}; 