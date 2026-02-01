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
        Schema::create('idle_alchemy_experiments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('player_id')
                ->constrained('idle_players')
                ->cascadeOnDelete();

            // Snapshot of ingredients at start
            $table->json('ingredients');

            // Deterministic RNG
            $table->string('seed');

            // Timing
            $table->timestamp('started_at');
            $table->timestamp('completes_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            // Lifecycle
            $table->string('status'); // pending | completed

            // Outcome
            $table->string('result')->nullable(); // success | partial | failure
            $table->json('result_payload')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alchemy_experiments');
    }
};
