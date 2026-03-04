<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Recipe;
use App\Enums\PotionType;
use App\Enums\ItemQuality;

class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(3, true),
            'potion_type' => $this->faker->randomElement(
                array_map(fn ($e) => $e->value, PotionType::cases())
            ),

            // Keep this simple by default — tests can override
            'ingredient_requirements' => [
                [
                    'ingredient_id' => 1,
                    'min' => 1,
                ],
            ],

            'min_total_ingredients' => 1,
            'min_quality' => null,
            'difficulty' => $this->faker->numberBetween(2, 6),
            'enabled' => true,
        ];
    }

    /**
     * Common helper for explicit healing recipe
     */
    public function healing(): self
    {
        return $this->state([
            'name' => 'Minor Healing Potion',
            'potion_type' => PotionType::Healing->value,
            'ingredient_requirements' => [
                ['ingredient_id' => 1, 'min' => 2],
            ],
            'min_total_ingredients' => 2,
            'min_quality' => ItemQuality::Common->value,
            'difficulty' => 3,
        ]);
    }

    /**
     * Fire-based recipe example
     */
    public function fire(): self
    {
        return $this->state([
            'name' => 'Fire Tonic',
            'potion_type' => PotionType::FireResistance->value,
            'ingredient_requirements' => [
                ['ingredient_id' => 2, 'min' => 1],
                ['ingredient_id' => 1, 'min' => 1],
            ],
            'min_total_ingredients' => 2,
            'min_quality' => ItemQuality::Uncommon->value,
            'difficulty' => 5,
        ]);
    }

    /**
     * Disabled recipe (useful in tests)
     */
    public function disabled(): self
    {
        return $this->state([
            'enabled' => false,
        ]);
    }
}
