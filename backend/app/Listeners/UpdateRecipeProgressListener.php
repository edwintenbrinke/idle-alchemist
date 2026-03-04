<?php

namespace App\Listeners;

use App\Enums\ItemQuality;
use App\Events\AlchemyExperimentCompletedEvent;
use App\Models\AlchemyExperiment;
use App\Models\Recipe;
use App\Models\RecipeProgress;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateRecipeProgressListener
{
    public function handle(AlchemyExperimentCompletedEvent $event): void
    {
        $experiment = $event->experiment;
        $player = $experiment->player;

        $recipes = Recipe::where('enabled', true)->get();

        foreach ($recipes as $recipe) {
            if (! $this->matchesExperiment($recipe, $experiment)) {
                continue;
            }

            $progress = RecipeProgress::firstOrCreate(
                [
                    'player_id' => $player->id,
                    'recipe_id' => $recipe->id,
                ],
                [
                    'required_progress' => $recipe->difficulty,
                ]
            );

            if ($progress->discovered) {
                continue;
            }

            $progress->increment('progress');

            if ($progress->progress >= $progress->required_progress) {
                $progress->update([
                    'discovered' => true,
                    'discovered_at' => now(),
                ]);
            }
        }
    }

    protected function matchesExperiment(Recipe $recipe, AlchemyExperiment $experiment): bool
    {
        if (! $experiment->isCompleted()) {
            return false;
        }

        if ($experiment->result !== 'success' && $experiment->result !== 'partial') {
            return false;
        }

        // Potion type must match
        if ($experiment->potionType()?->value !== $recipe->potion_type) {
            return false;
        }

        // Minimum quality (if defined)
        if ($recipe->min_quality !== null) {
            $quality = $experiment->potionQuality();

            if ($quality === null || $quality->isLowerThan(
                    ItemQuality::from($recipe->min_quality)
                )) {
                return false;
            }
        }

        // Seed requirements
        foreach ($recipe->ingredient_requirements as $requirement) {
            $used = collect($experiment->ingredients)
                ->where('ingredient_id', $requirement['ingredient_id'])
                ->sum('amount');

            if ($used < $requirement['min']) {
                return false;
            }
        }

        return true;
    }
}
