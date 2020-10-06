<?php

declare(strict_types=1);

class Bag
{
    private array $bag = [];

    public function getBag(): array
    {
        return $this->bag;
    }

    public function putProductInBag(string $product, int $amount): void
    {
        if ($amount > 0) {
            if (isset($this->bag[$product])) {
                $this->bag[$product] += $amount;
            } else {
                $this->bag += [$product => $amount];
            }
        }
    }
}
