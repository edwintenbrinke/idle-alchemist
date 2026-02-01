<?php

namespace App\Models;

use App\Enums\AlchemyExperimentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlchemyExperiment extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'ingredients',
        'seed',
        'started_at',
        'completes_at',
        'completed_at',
        'status',
        'result',
        'result_payload',
    ];

    protected $casts = [
        'ingredients' => 'array',
        'result_payload' => 'array',
        'started_at' => 'datetime',
        'completes_at' => 'datetime',
        'completed_at' => 'datetime',
        'status' => AlchemyExperimentStatus::class,
    ];

    protected $table = 'idle_alchemy_experiments';

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function isPending(): bool
    {
        return $this->status === AlchemyExperimentStatus::PENDING;
    }

    public function isCompleted(): bool
    {
        return $this->status === AlchemyExperimentStatus::COMPLETED;
    }
}
