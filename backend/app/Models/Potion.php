<?php

namespace App\Models;

use App\Enums\ItemQuality;
use App\Enums\PotionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Potion extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'alchemy_experiment_id',
        'type',
        'quality',
        'potency',
    ];

    protected $casts = [
        'type' => PotionType::class,
        'quality' => ItemQuality::class,

    ];

    protected $table = 'idle_potions';

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function alchemyExperiment(): BelongsTo
    {
        return $this->belongsTo(AlchemyExperiment::class, 'alchemy_experiment_id');
    }
}
