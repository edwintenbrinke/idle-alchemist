<?php

namespace App\Events;

use App\Models\FarmPlot;
use Illuminate\Queue\SerializesModels;

class PlayerHarvestedEvent
{
    use SerializesModels;

    public FarmPlot $plot;

    public function __construct(FarmPlot $plot)
    {
        $this->plot = $plot;
    }
}

