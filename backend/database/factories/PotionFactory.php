<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Potion;
use App\Models\Player;
use App\Models\AlchemyExperiment;

class PotionFactory extends Factory
{
    protected $model = Potion::class;

    public function definition(): array
    {
        return [
            'player_id' => Player::factory(),
            'alchemy_experiment_id' => AlchemyExperiment::factory(),
            'type' => $this->faker->randomElement(['healing', 'mana', 'fire_resist']),
            'quality' => $this->faker->randomElement(['common', 'rare', 'epic']),
            'potency' => $this->faker->numberBetween(5, 50),
        ];
    }
}

