<?php

namespace App\Models;

use App\Enums\InventoryType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Player extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'uuid', 'name', 'level', 'experience', 'inventory', 'knowledge', 'experiments_started'
    ];

    protected $casts = [
        'inventory' => 'array',
    ];

    protected $table = 'idle_players';

    public function farmPlots()
    {
        return $this->hasMany(FarmPlot::class);
    }

    public function inventoryByType(InventoryType $type): ?array
    {
        return $this->inventory[$type->value] ?? null;
    }
}

