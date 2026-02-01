<?php

namespace App\Listeners;

use App\Events\AlchemyExperimentCompletedEvent;

class GrantKnowledgeListener
{
    public function handle(AlchemyExperimentCompletedEvent $event): void
    {
        $player = $event->experiment->player;

        $knowledge = match ($event->result) {
            'success' => 5,
            'partial' => 8,
            'failure' => 15,
            default => 0,
        };

        if ($knowledge === 0) {
            return;
        }

        $player->increment('knowledge', $knowledge);
    }
}

