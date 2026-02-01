<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('idle_players', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('name');
            $table->integer('level')->default(1);
            $table->integer('experience')->default(0);
            $table->integer('knowledge')->default(0);
            $table->integer('experiments_started')->default(0);
            $table->json('inventory')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('players');
    }
};
