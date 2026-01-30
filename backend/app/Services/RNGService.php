<?php

namespace App\Services;

class RNGService
{
    protected int $seed;

    public function __construct(int $seed)
    {
        $this->seed = $seed;
    }

    public function randomInt(int $min, int $max): int
    {
        mt_srand($this->seed);
        $value = mt_rand($min, $max);
        $this->seed++;
        return $value;
    }

    public function chance(float $probability): bool
    {
        return $this->randomInt(1, 10000) <= $probability * 10000;
    }
}
