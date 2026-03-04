<?php

namespace App\Enums;

enum ItemQuality: string
{
    case Common = 'common';
    case Uncommon = 'uncommon';
    case Rare = 'rare';
    case Epic = 'epic';
    case Legendary = 'legendary';

    public function multiplier(): float
    {
        return match ($this) {
            self::Common => 1.0,
            self::Uncommon => 1.25,
            self::Rare => 1.6,
            self::Epic => 2.2,
            self::Legendary => 3.0,
        };
    }

    public function dropWeight(): int
    {
        return match ($this) {
            self::Common => 1000,
            self::Uncommon => 400,
            self::Rare => 120,
            self::Epic => 25,
            self::Legendary => 3,
        };
    }

    public static function rarityOrder(): array
    {
        return [
            self::Legendary,
            self::Epic,
            self::Rare,
            self::Uncommon,
            self::Common,
        ];
    }

    public function isLowerThan(ItemQuality $other): bool
    {
        return array_search($this, self::rarityOrder(), true)
            > array_search($other, self::rarityOrder(), true);
    }

    public function isHigherThan(ItemQuality $other): bool
    {
        return array_search($this, self::rarityOrder(), true)
            < array_search($other, self::rarityOrder(), true);
    }

    public function isAtLeast(ItemQuality $other): bool
    {
        return ! $this->isLowerThan($other);
    }
}

