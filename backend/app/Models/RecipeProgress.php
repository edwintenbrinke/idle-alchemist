<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeProgress extends Model
{
    protected $fillable = [
        'player_id',
        'recipe_id',
        'progress',
        'required_progress',
        'discovered',
        'discovered_at',
    ];

    protected $casts = [
        'discovered' => 'boolean',
        'discovered_at' => 'datetime',
    ];

    protected $table = 'idle_recipe_progress';

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
