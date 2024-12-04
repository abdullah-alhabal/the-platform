<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('our_teams', static function (Blueprint $table): void {
            $table->id();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('our_team_translations', static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('our_team_id')->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('name');
            $table->string('job')->nullable();
            $table->text('description')->nullable();
            $table->unique(['our_team_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('our_team_translations');
        Schema::dropIfExists('our_teams');
    }
};
