<?php

namespace App\Enums;

enum PotionType: string
{
    // Core combat
    case Healing = 'healing';
    case Mana = 'mana';
    case Stamina = 'stamina';

    // Buffs
    case Strength = 'strength';
    case Defense = 'defense';
    case Speed = 'speed';
    case CriticalChance = 'critical_chance';

    // Elemental
    case FireResistance = 'fire_resistance';
    case IceResistance = 'ice_resistance';
    case PoisonResistance = 'poison_resistance';

    case FireDamage = 'fire_damage';
    case IceDamage = 'ice_damage';
    case PoisonDamage = 'poison_damage';

    // Utility / meta
    case Luck = 'luck';
    case Experience = 'experience';
    case GoldFind = 'gold_find';

    // Farming / idle
    case GrowthSpeed = 'growth_speed';
    case YieldBonus = 'yield_bonus';

    public function isBuff(): bool
    {
        return in_array($this, [
            self::Strength,
            self::Defense,
            self::Speed,
            self::CriticalChance,
            self::Luck,
            self::Experience,
            self::GoldFind,
        ], true);
    }

    public function isElemental(): bool
    {
        return str_contains($this->value, 'fire')
            || str_contains($this->value, 'ice')
            || str_contains($this->value, 'poison');
    }
}
