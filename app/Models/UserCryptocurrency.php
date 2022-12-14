<?php

namespace App\Models;

class UserCryptocurrency
{
    private int $id;
    private string $symbol;
    private float $price;
    private int $amount;
    private float $priceNow;

    public function __construct(int $id, string $symbol, float $price, int $amount, float $priceNow)
    {
        $this->id = $id;
        $this->symbol = $symbol;
        $this->price = $price;
        $this->amount = $amount;
        $this->priceNow = $priceNow;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getPriceNow(): float
    {
        return $this->priceNow;
    }
}
