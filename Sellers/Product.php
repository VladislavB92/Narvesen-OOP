<?php

declare(strict_types=1);

class Product
{
    private string $name;
    private int $pricePerUnit;
    private int $stockAmount;

    public function __construct(
        string $name,
        int $price,
        int $stockAmount
    ) {
        $this->name = $name;
        $this->pricePerUnit = $price;
        $this->stockAmount = $stockAmount;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPricePerUnit(): int
    {
        return $this->pricePerUnit;
    }

    public function getStockAmount(): int
    {
        return $this->stockAmount;
    }

    public function removeProduct(): void
    {
        if ($this->stockAmount > 0) {
            $this->stockAmount--;
        }
    }
}
