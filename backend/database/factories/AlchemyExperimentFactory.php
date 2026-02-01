<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\AlchemyExperiment;
use App\Models\Player;
use Illuminate\Support\Str;

class AlchemyExperimentFactory extends Factory
{
    protected $model = AlchemyExperiment::class;

    public function definition(): array
    {
        return [
            'player_id' => Player::factory(),
            'ingredients' => [
                ['ingredient' => 'Herb', 'amount' => 2],
                ['ingredient' => 'Flower', 'amount' => 1],
            ],
            'seed' => Str::random(16),
            'started_at' => now(),
            'completes_at' => now()->addMinutes(10),
            'completed_at' => null,
            'status' => 'pending',
            'result' => null,
            'result_payload' => null,
        ];
    }

    public function completed(string $result = 'success'): static
    {
        return $this->state(fn () => [
            'status' => 'completed',
            'completed_at' => now(),
            'result' => $result,
            'result_payload' => [
                'quality' => 'common',
                'potency' => rand(5, 15),
            ],
        ]);
    }
}

