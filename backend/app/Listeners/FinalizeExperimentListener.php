<?php

namespace App\Listeners;

use App\Enums\AlchemyExperimentStatus;
use App\Events\AlchemyExperimentCompletedEvent;

class FinalizeExperimentListener
{
    public function handle(AlchemyExperimentCompletedEvent $event): void
    {
        $experiment = $event->experiment;

        if ($experiment->isCompleted()) {
            return; // idempotency
        }

        $experiment->update([
            'status' => AlchemyExperimentStatus::COMPLETED,
            'result' => $event->result,
            'result_payload' => $event->payload,
            'completed_at' => now(),
        ]);
    }
}

