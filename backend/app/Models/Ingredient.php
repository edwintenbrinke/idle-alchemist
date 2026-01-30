<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ingredient extends Model
{
    protected $fillable = [
        'uuid', 'name', 'growth_hours', 'yield_min', 'yield_max', 'mutation_chance'
    ];

    protected $table = 'idle_ingredients';

//    protected static function boot()
//    {
//        parent::boot();
//
//        static::creating(function ($model) {
//            if (empty($model->uuid)) {
//                $model->uuid = (string) Str::uuid(); // auto-generate UUID
//            }
//        });
//    }
}

