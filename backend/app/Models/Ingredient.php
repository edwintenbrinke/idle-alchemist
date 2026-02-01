<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid', 'name', 'growth_hours', 'yield_min', 'yield_max', 'mutation_chance'
    ];

    protected $table = 'idle_ingredients';
}

