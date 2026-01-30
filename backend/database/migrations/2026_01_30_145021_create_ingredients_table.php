<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('idle_ingredients', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('name');
            $table->integer('growth_hours')->default(1);
            $table->integer('yield_min')->default(1);
            $table->integer('yield_max')->default(3);
            $table->integer('mutation_chance')->default(5);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('ingredients');
    }
};

