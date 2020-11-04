<?php

declare(strict_types=1);

class Client
{
    private string $name;
    private int $money;

    public function __construct(string $name)
    {
        $this->name = $name;

        $this->money = intval(file_get_contents('Customers/Wallet.txt'));
    }

    public function getClientsName(): string
    {
        return $this->name;
    }

    public function getClientsFunds(): int
    {
        return $this->money;
    }

    public function buyProduct(
        string $productName,
        int $productPrice,
        int $amount
    ): string {
        
        $totalPrice = $productPrice * $amount;
        if ($this->money >= $totalPrice) {

            $this->money -= $totalPrice;
            file_put_contents('Customers/Wallet.txt', $this->money);

            return $productName;
        } else {
            exit("\nUmm... Wait. Sorry, I don't have enough money for that. Bye!\n");
        }
    }
}
