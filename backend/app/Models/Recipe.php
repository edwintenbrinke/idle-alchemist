<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'potion_type',
        'ingredient_requirements',
        'min_total_ingredients',
        'min_quality',
        'difficulty',
        'enabled',
    ];

    protected $casts = [
        'ingredient_requirements' => 'array',
    ];

    protected $table = 'idle_recipes';
}
