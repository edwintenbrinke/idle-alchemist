<?php

namespace Tests\Feature;

use App\Enums\AlchemyExperimentStatus;
use App\Jobs\CompleteAlchemyExperimentJob;
use App\Models\AlchemyExperiment;
use App\Models\Player;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class StartAlchemyExperimentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function starting_an_experiment_deducts_inventory_and_queues_job(): void
    {
        Queue::fake();

        // Arrange
        $player = Player::factory()->create([
            'inventory' => [
                'mandrake_root' => 5,
                'fire_bloom' => 3,
            ],
            'experiments_started' => 0,
        ]);

        $payload = [
            'ingredients' => [
                'mandrake_root' => 2,
                'fire_bloom' => 1,
            ],
        ];

        // Act
        $response = $this
//            ->actingAs($player, 'sanctum')
            ->postJson('/api/alchemy/experiments', $payload);

        // Assert: response
        $response->assertCreated();
        $response->assertJsonStructure([
            'experiment_id',
            'completes_at',
        ]);

        // Assert: experiment created
        $this->assertDatabaseCount('idle_alchemy_experiments', 1);

        $experiment = AlchemyExperiment::first();

        $this->assertEquals($player->id, $experiment->player_id);
        $this->assertEquals($payload['ingredients'], $experiment->ingredients);
        $this->assertEquals(AlchemyExperimentStatus::PENDING, $experiment->status);

        // Assert: inventory deducted
        $player->refresh();

        $this->assertEquals(3, $player->inventory['mandrake_root']);
        $this->assertEquals(2, $player->inventory['fire_bloom']);

        // Assert: job queued with delay
        Queue::assertPushed(CompleteAlchemyExperimentJob::class, function ($job) use ($experiment) {
            return $job->experiment_id === $experiment->id;
        });
    }
}
