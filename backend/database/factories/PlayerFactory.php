<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Player;
use Illuminate\Support\Str;

class PlayerFactory extends Factory
{
    protected $model = Player::class;

    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'name' => $this->faker->userName(),
            'level' => $this->faker->numberBetween(1, 10),
            'experience' => $this->faker->numberBetween(0, 500),
            'knowledge' => $this->faker->numberBetween(0, 100),
            'experiments_started' => 0,
            'inventory' => [],
        ];
    }

    public function veteran(): static
    {
        return $this->state(fn () => [
            'level' => 20,
            'knowledge' => 250,
        ]);
    }
}
