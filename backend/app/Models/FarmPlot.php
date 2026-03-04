<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmPlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid', 'player_id', 'seed_id', 'planted_at', 'growth_hours'
    ];

    protected $casts = [
        'planted_at' => 'datetime',
    ];

    protected $table = 'idle_farm_plots';

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function seed()
    {
        return $this->belongsTo(Seed::class);
    }
}

