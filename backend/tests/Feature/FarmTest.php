<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Tests\TestCase;
use App\Models\Player;
use App\Models\FarmPlot;
use App\Models\Ingredient;
use App\Jobs\CompleteCropJob;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FarmTest extends TestCase
{
    use RefreshDatabase;

    public function testPlantAndHarvest()
    {
        $this->seed(DatabaseSeeder::class);

        $player = Player::first();
        $plot = $player->farmPlots()->first();
        $ingredient = Ingredient::first();

        // Plant
        $plot->update([
            'ingredient_id' => $ingredient->id,
            'planted_at' => now(),
            'growth_hours' => $ingredient->growth_hours
        ]);

        // Simulate crop growth completion
        CompleteCropJob::dispatchSync($plot);

        $player->refresh();
        dd($player);
        $this->assertArrayHasKey($ingredient->name, $player->inventory);
        $this->assertGreaterThanOrEqual($ingredient->yield_min, $player->inventory[$ingredient->name]);
    }
}
