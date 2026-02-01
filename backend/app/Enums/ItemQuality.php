<?php

namespace App\Enums;

enum ItemQuality: string
{
    case COMMON = 'common';
    case UNCOMMON = 'uncommon';
    case RARE = 'rare';
    case EPIC = 'epic';
    case LEGENDARY = 'legendary';

    public function multiplier(): float
    {
        return match ($this) {
            self::COMMON => 1.0,
            self::UNCOMMON => 1.25,
            self::RARE => 1.6,
            self::EPIC => 2.2,
            self::LEGENDARY => 3.0,
        };
    }

    public function dropWeight(): int
    {
        return match ($this) {
            self::COMMON => 1000,
            self::UNCOMMON => 400,
            self::RARE => 120,
            self::EPIC => 25,
            self::LEGENDARY => 3,
        };
    }

    public static function rarityOrder(): array
    {
        return [
            self::LEGENDARY,
            self::EPIC,
            self::RARE,
            self::UNCOMMON,
            self::COMMON,
        ];
    }
}

