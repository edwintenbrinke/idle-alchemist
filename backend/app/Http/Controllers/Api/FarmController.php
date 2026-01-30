<?php

// app/Http/Controllers/Api/FarmController.php
namespace App\Http\Controllers\Api;

use App\Jobs\CompleteCropJob;
use App\Models\FarmPlot;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;

class FarmController extends Controller
{
    public function plant(Request $request, FarmPlot $plot)
    {
        $request->validate([
            'ingredient_id' => [
//                'required|exists:idle_ingredients,id'
                Rule::exists(Ingredient::class, 'id'),
            ]
        ]);

        $ingredient = Ingredient::findOrFail($request->ingredient_id);
        $now = now();
        $plot->update([
            'ingredient_id' => $ingredient->id,
            'planted_at' => $now,
        ]);

        // Dispatch completion job
        CompleteCropJob::dispatch($plot)->delay($now->copy()->addHours($ingredient->growth_hours));

        return response()->json(['message' => 'Seed planted.']);
    }
}
