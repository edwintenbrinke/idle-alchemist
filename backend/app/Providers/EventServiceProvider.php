<?php

namespace App\Providers;

use App\Events\AlchemyExperimentCompletedEvent;
use App\Listeners\CreatePotionListener;
use App\Listeners\FinalizeExperimentListener;
use App\Listeners\GrantKnowledgeListener;

class EventServiceProvider
{
    protected $listen = [
        AlchemyExperimentCompletedEvent::class => [
            CreatePotionListener::class,
            GrantKnowledgeListener::class,
            FinalizeExperimentListener::class,
        ],
    ];
}
