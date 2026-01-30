<?php

namespace App\Jobs;

use App\Models\FarmPlot;
use App\Events\PlayerHarvestedEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CompleteCropJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public FarmPlot $plot;

    public function __construct(FarmPlot $plot)
    {
        $this->plot = $plot;
    }

    public function handle()
    {
        // Trigger harvest event
        event(new PlayerHarvestedEvent($this->plot));
    }
}
