<?php

namespace App\Jobs;

use App\Enums\AlchemyExperimentStatus;
use App\Events\AlchemyExperimentCompletedEvent;
use App\Models\AlchemyExperiment;
use App\Services\RNGService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CompleteAlchemyExperimentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly int $experiment_id
    ) {}

    public function handle(): void
    {
        $experiment = AlchemyExperiment::findOrFail($this->experiment_id);

        if ($experiment->isCompleted()) {
            return; // idempotency
        }

        // Create deterministic RNG for this experiment
        $rng = new RNGService($experiment->seed);

        // Roll experiment outcome deterministically
        $roll = $rng->randomInt(1, 100);

        $result = match (true) {
            $roll <= 60 => 'failure',
            $roll <= 90 => 'partial',
            default => 'success',
        };

        $payload = [ 'roll' => $roll ];

        // Fire the event — CreatePotionListener will handle potion creation
        event(new AlchemyExperimentCompletedEvent( experiment: $experiment, result: $result, payload: $payload ));
    }
}

