<?php

namespace App\Listeners;

use App\Enums\ItemQuality;
use App\Enums\PotionType;
use App\Events\AlchemyExperimentCompletedEvent;
use App\Models\Potion;
use App\Services\RNGService;

class CreatePotionListener
{
    public function handle(
        AlchemyExperimentCompletedEvent $event,
    ): void {
        if (!in_array($event->result, ['success', 'partial'], true)) {
            return;
        }

        $experiment = $event->experiment;

        // Reseed for deterministic replay
        $rng = new RNGService($experiment->seed . ':potion');

        /** ------------------------
         * Roll potion type
         * ------------------------ */
        $types = PotionType::cases();
        $type = $types[$rng->randomInt(0, count($types) - 1)];

        /** ------------------------
         * Roll quality
         * ------------------------ */
        $quality = $rng->generateDropRarity();

        /** ------------------------
         * Potency
         * ------------------------ */
        $basePotency = $rng->randomInt(10, 20);
        $potency = (int) round($basePotency * $quality->multiplier());

        Potion::create([
            'player_id' => $experiment->player_id,
            'alchemy_experiment_id' => $experiment->id,
            'type' => $type,
            'quality' => $quality,
            'potency' => $potency,
        ]);
    }
}

