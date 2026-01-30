<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FarmPlot extends Model
{
    protected $fillable = [
        'uuid', 'player_id', 'ingredient_id', 'planted_at', 'growth_hours'
    ];

    protected $casts = [
        'planted_at' => 'datetime',
    ];

    protected $table = 'idle_farm_plots';

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
}

