<?php

namespace Tests\Feature;

use App\Enums\AlchemyExperimentStatus;
use App\Jobs\CompleteAlchemyExperimentJob;
use App\Models\AlchemyExperiment;
use App\Models\Player;
use App\Models\Potion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlchemyExperimentDeterminismTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function identical_experiments_produce_identical_results(): void
    {
        // Arrange
        $player = Player::factory()->create([
            'knowledge' => 0,
        ]);

        $ingredients = [
            'mandrake_root' => 2,
            'fire_bloom' => 1,
        ];

        $seed = 'test-seed-123';

        // Create two identical experiments
        $experimentA = AlchemyExperiment::create([
            'player_id' => $player->id,
            'ingredients' => $ingredients,
            'seed' => $seed,
            'started_at' => now(),
            'completes_at' => now(),
            'status' => AlchemyExperimentStatus::PENDING,
        ]);

        $experimentB = AlchemyExperiment::create([
            'player_id' => $player->id,
            'ingredients' => $ingredients,
            'seed' => $seed,
            'started_at' => now(),
            'completes_at' => now(),
            'status' => AlchemyExperimentStatus::PENDING,
        ]);

        // Act
        (new CompleteAlchemyExperimentJob($experimentA->id))->handle();
        (new CompleteAlchemyExperimentJob($experimentB->id))->handle();

        // Refresh models
        $experimentA->refresh();
        $experimentB->refresh();

        // Assert: experiment state
        $this->assertEquals(AlchemyExperimentStatus::COMPLETED, $experimentA->status);
        $this->assertEquals($experimentA->status, $experimentB->status);
        $this->assertEquals($experimentA->result, $experimentB->result);
        $this->assertEquals($experimentA->result_payload, $experimentB->result_payload);

        // Assert: potion determinism
        $potionA = Potion::where('alchemy_experiment_id', $experimentA->id)->first();
        $potionB = Potion::where('alchemy_experiment_id', $experimentB->id)->first();

        if ($experimentA->result === 'failure') {
            $this->assertNull($potionA);
            $this->assertNull($potionB);
        } else {
            $this->assertNotNull($potionA);
            $this->assertNotNull($potionB);

            $this->assertEquals($potionA->type, $potionB->type);
            $this->assertEquals($potionA->quality, $potionB->quality);
            $this->assertEquals($potionA->potency, $potionB->potency);
        }
    }
}

