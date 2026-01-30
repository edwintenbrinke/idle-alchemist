<?php

namespace Database\Seeders;

use App\Models\FarmPlot;
use App\Models\Ingredient;
use App\Models\Player;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a player
        $player = Player::create([
            'uuid' => Str::uuid()->toString(),
            'name' => 'TestPlayer',
            'inventory' => [],
        ]);

        // Create some ingredients
        $herb = Ingredient::create([
            'uuid' => Str::uuid()->toString(),
            'name' => 'Herb',
            'growth_hours' => 2,
            'yield_min' => 1,
            'yield_max' => 3,
            'mutation_chance' => 5,
        ]);

        $flower = Ingredient::create([
            'uuid' => Str::uuid()->toString(),
            'name' => 'Flower',
            'growth_hours' => 1,
            'yield_min' => 2,
            'yield_max' => 4,
            'mutation_chance' => 1,
        ]);

        // Create 3 farm plots for the player
        for ($i = 0; $i < 3; $i++) {
            FarmPlot::create([
                'uuid' => Str::uuid()->toString(),
                'player_id' => $player->id
            ]);
        }
    }
}
