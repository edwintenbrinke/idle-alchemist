<?php

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
        Schema::create('idle_recipes', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('potion_type'); // PotionType enum value

            // JSON so you can express flexible constraints
            $table->json('ingredient_requirements');
            /*
              Example:
              [
                { "ingredient_id": 1, "min": 2 },
                { "ingredient_id": 5, "min": 1 }
              ]
            */

            $table->unsignedInteger('min_total_ingredients');
            $table->enum('min_quality', ItemQuality::cases())->nullable(); // ItemQuality enum

            $table->unsignedInteger('difficulty'); // discovery difficulty
            $table->boolean('enabled')->default(true);

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idle_recipes');
    }
};
