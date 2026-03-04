<?php

use App\Enums\IngredientCategory;
use App\Enums\ItemQuality;
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
        Schema::create('idle_ingredients', function (Blueprint $table) {
            $table->id();

            // Identity
            $table->string('name');
            $table->string('slug')->unique();

            // Classification
            $table->enum('category', IngredientCategory::cases());
            // e.g. herb, mineral, essence, fish, monster_part

            // Optional design tags
            $table->json('tags')->nullable();
            // e.g. ["fire", "nature", "aquatic"]

            // Balance hooks
            $table->enum('base_rarity', ItemQuality::cases()); // 1–5
            $table->unsignedInteger('base_value')->default(1);

            // Lore / UX
            $table->text('description')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idle_ingredients');
    }
};
