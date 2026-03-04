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
}
