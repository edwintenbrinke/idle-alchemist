<?php

namespace Tests\Feature\Alchemy;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Player;
use App\Models\Recipe;
use App\Models\RecipeProgress;
use App\Models\AlchemyExperiment;
use App\Events\AlchemyExperimentCompletedEvent;

class RecipeDiscoveryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function recipe_is_discovered_after_enough_matching_experiments()
    {
        // Arrange
        $this->seed();

        $player = Player::factory()->create();
        $recipe = Recipe::where('name', 'Minor Healing Potion')->firstOrFail();

        // Act: run enough matching experiments
        for ($i = 0; $i < $recipe->difficulty; $i++) {
            $experiment = AlchemyExperiment::factory()
                ->completed()
                ->create([
                    'player_id' => $player->id,
                    'ingredients' => [
                        ['ingredient_id' => 1, 'amount' => 2],
                    ],
                    'result_payload' => [
                        'potion_type' => 'healing',
                        'quality' => 'common',
                        'potency' => 10,
                    ],
                ]);

            event(new AlchemyExperimentCompletedEvent($experiment, 'success'));
        }

        // Assert
        $progress = RecipeProgress::where('player_id', $player->id)
            ->where('recipe_id', $recipe->id)
            ->first();

        $this->assertNotNull($progress);
        $this->assertTrue($progress->discovered);
        $this->assertNotNull($progress->discovered_at);
        $this->assertGreaterThanOrEqual(
            $progress->required_progress,
            $progress->progress
        );
    }
}
