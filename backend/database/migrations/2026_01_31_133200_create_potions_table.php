<?php

use App\Enums\ItemQuality;
use App\Enums\PotionType;
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
        Schema::create('idle_potions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('player_id')
                ->constrained('idle_players')
                ->cascadeOnDelete();

            $table->foreignId('alchemy_experiment_id')
                ->constrained('idle_alchemy_experiments')
                ->cascadeOnDelete();

            $table->enum('type', PotionType::cases());        // e.g. healing, fire_resist
            $table->enum('quality', ItemQuality::cases());     // common, rare, epic
            $table->integer('potency');    // numeric effect strength

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idle_potions');
    }
};
