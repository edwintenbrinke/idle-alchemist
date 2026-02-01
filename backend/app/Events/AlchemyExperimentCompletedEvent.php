<?php

namespace App\Events;

use App\Models\AlchemyExperiment;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AlchemyExperimentCompletedEvent
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly AlchemyExperiment $experiment,
        public readonly string $result,          // success | partial | failure
        public readonly array $payload = []       // RNG rolls, debug info
    ) {}
}

