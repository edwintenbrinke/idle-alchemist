<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('idle_farm_plots', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('player_id')->constrained('idle_players')->cascadeOnDelete();
            $table->foreignId('seed_id')->nullable()->constrained('idle_seeds')->nullOnDelete();
            $table->timestamp('planted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('idle_farm_plots');
    }
};

