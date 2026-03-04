<?php

namespace Tests\Feature;

use App\Enums\InventoryType;
use Database\Seeders\DatabaseSeeder;
use Tests\TestCase;
use App\Models\Player;
use App\Models\FarmPlot;
use App\Models\Seed;
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
        $ingredient = Seed::first();

        // Plant
        $plot->update([
            'ingredient_id' => $ingredient->id,
            'planted_at' => now(),
        ]);

        // Simulate crop growth completion
        CompleteCropJob::dispatchSync($plot);

        $player->refresh();
        $this->assertArrayHasKey($ingredient->id, $player->inventory[InventoryType::Herbs]);
        $this->assertGreaterThanOrEqual($ingredient->yield_min, $player->inventory[InventoryType::Herbs][$ingredient->id]);
    }
}
