<?php

namespace Database\Factories;

use App\Models\FarmPlot;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Player;
use App\Models\Seed;
use Illuminate\Support\Str;

class FarmPlotFactory extends Factory
{
    protected $model = FarmPlot::class;

    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'player_id' => Player::factory(),
            'seed_id' => null,
            'planted_at' => null,
        ];
    }

    public function planted(): static
    {
        return $this->state(fn () => [
            'seed_id' => Seed::factory(),
            'planted_at' => now()->subHours(rand(0, 3)),
        ]);
    }
}

