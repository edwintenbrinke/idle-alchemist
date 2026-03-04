<?php

namespace Database\Factories;

use App\Enums\IngredientCategory;
use App\Enums\ItemQuality;
use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;

class IngredientFactory extends Factory
{
    protected $model = Ingredient::class;

    public function definition(): array
    {
        return [
            'name' => ucfirst($this->faker->unique()->word()),
            'slug' => $this->faker->unique()->slug(),
            'category' => $this->faker->randomElement(
                array_map(fn ($e) => $e->value, IngredientCategory::cases())
            ),
            'tags' => $this->faker->randomElements(
                ['fire', 'ice', 'nature', 'poison', 'aquatic'],
                rand(1, 2)
            ),
            'base_rarity' => $this->faker->randomElement(
                array_map(fn ($e) => $e->value, ItemQuality::cases())
            ),
            'base_value' => $this->faker->numberBetween(1, 20),
        ];
    }

    public function herb(): static
    {
        return $this->state([
            'category' => 'herb',
            'tags' => ['nature'],
        ]);
    }

    public function fish(): static
    {
        return $this->state([
            'category' => 'fish',
            'tags' => ['aquatic'],
        ]);
    }
}

