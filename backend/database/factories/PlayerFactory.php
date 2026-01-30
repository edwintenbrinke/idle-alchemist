<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Player;

class PlayerFactory extends Factory
{
    protected $model = Player::class;

    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->name(),
            'level' => $this->faker->numberBetween(1, 10),
            'experience' => $this->faker->numberBetween(0, 500),
            'inventory' => [],
        ];
    }
}
