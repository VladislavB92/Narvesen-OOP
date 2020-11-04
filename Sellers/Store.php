<?php

declare(strict_types=1);

class Store
{
    private string $storeName;
    private array $products = [];

    public function __construct(string $name)
    {
        $this->storeName = $name;
    }

    public function displayStoreName(): string
    {
        return $this->storeName;
    }

    public function all(): array
    {
        return $this->products;
    }

    public function countProductTypes(): int
    {
        return count($this->products);
    }

    public function sellProduct(Product $product, int $amount): string
    {
        if ($product->getStockAmount() >= $amount) {

            for ($i = 0; $i < $amount; $i++) {
                $product->removeProduct();
            }
            if ($amount > 1 && substr($product->getName(), -1) !== "s") {
                return $product->getName() . "s";
            }
            return $product->getName();
        } else {
            return "Clerk: Sorry. We don't have so many of those.";
        }
    }

    public function add(Product $product): void
    {
        $this->products[] = $product;
    }

    public function displaySortiment(): void
    {
        foreach ($this->products as $id => $product) {
            echo " = ID " . $id . " - " . $product->getName() .
                ", price: €" .
                CurrencyFormater::formatToDecimal($product->getPricePerUnit()) .
                ", amount: " . $product->getStockAmount() . " pieces" .
                PHP_EOL;
        }
    }
}
