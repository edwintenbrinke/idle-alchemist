<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Enums\PotionType;
use App\Enums\ItemQuality;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        Recipe::truncate();
        Ingredient::truncate();

        foreach (PotionType::cases() as $potionType) {
            // Create ingredient tied to this potion theme
            $ingredient = Ingredient::factory()->create([
                'name' => ucfirst(str_replace('_', ' ', $potionType->value)) . ' Herb',
            ]);

            Recipe::factory()->create([
                'name' => ucfirst(str_replace('_', ' ', $potionType->value)) . ' Potion',
                'potion_type' => $potionType->value,
                'ingredient_requirements' => [
                    [
                        'ingredient_id' => $ingredient->id,
                        'min' => 2,
                    ],
                ],
                'min_total_ingredients' => 2,
                'min_quality' => ItemQuality::Common->value,
                'difficulty' => 3,
            ]);
        }
    }
}
