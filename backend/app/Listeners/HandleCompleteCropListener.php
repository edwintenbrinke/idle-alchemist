<?php

namespace App\Listeners;

use App\Enums\InventoryType;
use App\Events\PlayerHarvestedEvent;
use App\Services\RNGService;

class HandleCompleteCropListener
{
    public function handle(PlayerHarvestedEvent $event)
    {
        $plot = $event->plot;
        $seed = $plot->seed;
        $player = $plot->player;

        $rng = new RNGService($player->id + $plot->id);
        $quantity = $rng->randomInt($seed->yield_min, $seed->yield_max);

        $seed_inventory = $player->inventoryByType(InventoryType::Seeds);

        $seed_inventory[$seed->id] = ($seed_inventory[$seed->id] ?? 0) + $quantity;
//        dd($inventory);
        $player->update(['inventory' => $inventory]);

        // Reset farm plot
        $plot->update(['seed_id' => null, 'planted_at' => null]);
    }
}
