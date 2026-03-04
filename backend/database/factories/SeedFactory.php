<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Seed;
use Illuminate\Support\Str;

class SeedFactory extends Factory
{
    protected $model = Seed::class;

    public function definition(): array
    {
        $yieldMin = $this->faker->numberBetween(1, 3);

        return [
            'uuid' => Str::uuid(),
            'name' => ucfirst($this->faker->unique()->word()),
            'growth_hours' => $this->faker->numberBetween(1, 6),
            'yield_min' => $yieldMin,
            'yield_max' => $yieldMin + $this->faker->numberBetween(1, 3),
            'mutation_chance' => $this->faker->numberBetween(0, 10),
        ];
    }

    public function fastGrowing(): static
    {
        return $this->state(fn () => [
            'growth_hours' => 1,
        ]);
    }
}

