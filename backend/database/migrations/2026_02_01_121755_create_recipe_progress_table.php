<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('idle_recipe_progress', function (Blueprint $table) {
            $table->id();

            $table->foreignId('player_id')->constrained('idle_players')->cascadeOnDelete();
            $table->foreignId('recipe_id')->constrained('idle_recipes')->cascadeOnDelete();

            $table->unsignedInteger('progress')->default(0);
            $table->unsignedInteger('required_progress');

            $table->boolean('discovered')->default(false);
            $table->timestamp('discovered_at')->nullable();

            $table->timestamps();

            $table->unique(['player_id', 'recipe_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idle_recipe_progress');
    }
};
