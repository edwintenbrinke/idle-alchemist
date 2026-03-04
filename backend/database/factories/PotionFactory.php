<?php

namespace Database\Factories;

use App\Enums\ItemQuality;
use App\Enums\PotionType;
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
            'type' => $this->faker->randomElement(
                array_map(fn ($e) => $e->value, PotionType::cases())
            ),
            'quality' => $this->faker->randomElement(
                array_map(fn ($e) => $e->value, ItemQuality::cases())
            ),
            'potency' => $this->faker->numberBetween(5, 50),
        ];
    }
}

