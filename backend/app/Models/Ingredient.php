<?php

namespace App\Models;

use App\Enums\ItemQuality;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'tags',
        'base_rarity',
        'base_value',
        'description',
    ];

    protected $casts = [
        'tags' => 'array',
        'base_rarity' => ItemQuality::class,
    ];

    protected $table = 'idle_ingredients';

    public function hasTag(string $tag): bool
    {
        return in_array($tag, $this->tags ?? [], true);
    }
}

