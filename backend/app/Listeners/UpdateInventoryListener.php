<?php

namespace App\Listeners;

use App\Events\PlayerHarvestedEvent;
use App\Services\RNGService;

class UpdateInventoryListener
{
    public function handle(PlayerHarvestedEvent $event)
    {
        $plot = $event->plot;
        $ingredient = $plot->ingredient;
        $player = $plot->player;

        $rng = new RNGService($player->id + $plot->id);
        $quantity = $rng->randomInt($ingredient->yield_min, $ingredient->yield_max);

        $inventory = $player->inventory ?? [];
        $inventory[$ingredient->name] = ($inventory[$ingredient->name] ?? 0) + $quantity;
        $player->update(['inventory' => $inventory]);

        // Reset farm plot
        $plot->update(['ingredient_id' => null, 'planted_at' => null]);
    }
}
