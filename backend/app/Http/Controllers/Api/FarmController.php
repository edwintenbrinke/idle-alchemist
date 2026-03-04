<?php

// app/Http/Controllers/Api/FarmController.php
namespace App\Http\Controllers\Api;

use App\Jobs\CompleteCropJob;
use App\Models\FarmPlot;
use App\Models\Seed;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;

class FarmController extends Controller
{
    public function plant(Request $request, FarmPlot $plot)
    {
        // TODO check if farm plot part of player auth
        $request->validate([
            'seed_id' => [
                Rule::exists(Seed::class, 'id'),
            ]
        ]);

        $ingredient = Seed::findOrFail($request->seed_id);
        $now = now();
        $plot->update([
            'seed_id' => $ingredient->id,
            'planted_at' => $now,
        ]);

        // TODO remove seeds form inventory

        // Dispatch completion job
        CompleteCropJob::dispatch($plot)->delay($now->copy()->addHours($ingredient->growth_hours));

        return response()->json(['message' => 'Seed planted.']);
    }
}
