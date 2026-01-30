<?php

namespace Database\Factories;

use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Player;

class IngredientFactory extends Factory
{
    protected $model = Ingredient::class;

    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->unique()->word(),
            'growth_hours' => $this->faker->numberBetween(1, 5),
            'yield_min' => $this->faker->numberBetween(1, 2),
            'yield_max' => $this->faker->numberBetween(3, 5),
            'mutation_chance' => $this->faker->randomFloat(2, 0.01, 0.2),
        ];
    }
}
