<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('work_steps', function (Blueprint $table): void {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('work_step_translations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('work_step_id')->constrained('work_steps')->cascadeOnDelete();
            $table->string('locale')->index();
            $table->longText('text');
            $table->timestamps();

            $table->unique(['work_step_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_step_translations');
        Schema::dropIfExists('work_steps');
    }
};
