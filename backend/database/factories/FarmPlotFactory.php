<?php

namespace Database\Factories;

use App\Models\FarmPlot;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Player;

class FarmPlotFactory extends Factory
{
    protected $model = FarmPlot::class;

    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid(),
            'player_id' => Player::factory(), // Automatically create a player if not provided
            'ingredient_id' => null,
            'planted_at' => null,
            'growth_hours' => 0,
        ];
    }
}
