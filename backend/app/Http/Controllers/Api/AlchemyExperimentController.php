<?php

namespace App\Http\Controllers\Api;

use App\Enums\AlchemyExperimentStatus;
use App\Jobs\CompleteAlchemyExperimentJob;
use App\Models\AlchemyExperiment;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AlchemyExperimentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'ingredients' => ['required', 'array', 'min:1'],
            'ingredients.*' => ['integer', 'min:1'],
        ]);

        // TODO after auth implemented
//        $player = $request->user();
        $player = Player::first();

        return DB::transaction(function () use ($player, $data) {
            $ingredients = $data['ingredients'];

            /** -------------------------
             * 1. Validate inventory
             * ------------------------- */
            foreach ($ingredients as $ingredientKey => $amount) {
                $owned = Arr::get($player->inventory, $ingredientKey, 0);

                if ($owned < $amount) {
                    throw ValidationException::withMessages([
                        'ingredients' => "Not enough {$ingredientKey}",
                    ]);
                }
            }

            /** -------------------------
             * 2. Deduct ingredients
             * ------------------------- */
            $inventory = $player->inventory;

            foreach ($ingredients as $ingredientKey => $amount) {
                $inventory[$ingredientKey] -= $amount;

                if ($inventory[$ingredientKey] <= 0) {
                    unset($inventory[$ingredientKey]);
                }
            }

            $player->update([
                'inventory' => $inventory,
            ]);

            /** -------------------------
             * 3. Deterministic seed
             * ------------------------- */
            $normalizedIngredients = collect($ingredients)
                ->sortKeys()
                ->toJson();

            $seed = hash('sha256', implode('|', [
                $player->id,
                $normalizedIngredients,
                $player->experiments_started ?? 0,
            ]));

            /** -------------------------
             * 4. Create experiment
             * ------------------------- */
            $experiment = AlchemyExperiment::create([
                'player_id' => $player->id,
                'ingredients' => $ingredients,
                'seed' => $seed,
                'started_at' => now(),
                'completes_at' => now()->addMinutes(5), // placeholder duration
                'status' => AlchemyExperimentStatus::PENDING,
            ]);

            /** -------------------------
             * 5. Dispatch job
             * ------------------------- */
            CompleteAlchemyExperimentJob::dispatch($experiment->id)
                ->delay($experiment->completes_at);

            /** -------------------------
             * 6. Track counter (optional)
             * ------------------------- */
            $player->increment('experiments_started');

            return response()->json([
                'experiment_id' => $experiment->id,
                'completes_at' => $experiment->completes_at,
            ], 201);
        });
    }
}

