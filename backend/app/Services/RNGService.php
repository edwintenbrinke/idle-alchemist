<?php

namespace App\Services;

use App\Enums\ItemQuality;

class RNGService
{
    protected int $seed;

    public function __construct(int|string $seed)
    {
        $this->setSeed($seed);
    }

    public function setSeed(int|string $seed)
    {
        $this->seed = crc32((string) $seed);
    }

    protected function next(): int
    {
        $this->seed = ($this->seed * 1103515245 + 12345) & 0x7fffffff;
        return $this->seed;
    }

    public function randomInt(int $min, int $max): int
    {
        return $min + ($this->next() % ($max - $min + 1));
    }

    public function chance(float $probability): bool
    {
        return $this->randomInt(1, 10_000) <= (int) ($probability * 10_000);
    }

    public function generateDropRarity(): ItemQuality
    {
        $total = array_sum(array_map(
            fn ($q) => $q->dropWeight(),
            ItemQuality::cases()
        ));

        $roll = $this->randomInt(1, $total);
        $current = 0;

        foreach (ItemQuality::rarityOrder() as $quality) {
            $current += $quality->dropWeight();
            if ($roll <= $current) {
                return $quality;
            }
        }

        return ItemQuality::COMMON;
    }
}
