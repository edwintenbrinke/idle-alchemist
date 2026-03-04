<?php

namespace Database\Seeders;

use App\Enums\ItemQuality;
use App\Enums\PotionType;
use App\Models\AlchemyExperiment;
use App\Models\FarmPlot;
use App\Models\Seed;
use App\Models\Player;
use App\Models\Potion;
use App\Models\Recipe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Ingredients catalog
        $ingredients = Seed::factory()
            ->count(6)
            ->create([
                'mutation_chance' => 5,
            ]);

        // Test player with farm plots
        $player = Player::factory()
            ->has(
                FarmPlot::factory()
                    ->count(3)
                    ->state(fn () => [
                        'seed_id' => $ingredients->random()->id,
                        'planted_at' => now()->subHour(),
                    ])
            )
            ->create([
                'name' => 'TestPlayer',
            ]);

        // Completed experiment + potion
        $experiment = AlchemyExperiment::factory()
            ->completed('success')
            ->for($player)
            ->create();

        Potion::factory()
            ->for($player)
            ->for($experiment)
            ->create([
                'type' => PotionType::Healing,
                'quality' => ItemQuality::Rare,
            ]);

        Potion::factory()
            ->for($player)
            ->for($experiment)
            ->create([
                'type' => PotionType::FireDamage,
                'quality' => ItemQuality::Legendary,
            ]);


        $this->call(RecipeSeeder::class);
    }
}

