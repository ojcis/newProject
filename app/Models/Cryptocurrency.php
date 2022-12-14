<?php

namespace App\Models;

class Cryptocurrency
{
    private string $symbol;
    private string $name;
    private float $price;
    private string $website;
    private string $description;
    private string $logo;
    private int $circulatingSupply;
    private float $percentChange1h;
    private float $percentChange24h;
    private float $percentChange7d;
    private float $volume24h;
    private string $currency;

    public function __construct(
        string $symbol,
        string $name,
        int    $circulatingSupply,
        float  $price,
        float  $percentChange1h,
        float  $percentChange24h,
        float  $percentChange7d,
        float  $volume24h,
        string $website,
        string $description,
        string $logo,
        string $currency
    )
    {
        $this->symbol = $symbol;
        $this->name = $name;
        $this->price = $price;
        $this->website = $website;
        $this->description = $description;
        $this->logo = $logo;
        $this->circulatingSupply = $circulatingSupply;
        $this->percentChange1h = $percentChange1h;
        $this->percentChange24h = $percentChange24h;
        $this->percentChange7d = $percentChange7d;
        $this->volume24h = $volume24h;
        $this->currency = $currency;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getWebsite(): string
    {
        return $this->website;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setLogo(string $logo): void
    {
        $this->logo = $logo;
    }

    public function getCirculatingSupply(): int
    {
        return $this->circulatingSupply;
    }

    public function getPercentChange1h(): float
    {
        return $this->percentChange1h;
    }

    public function getPercentChange7d(): float
    {
        return $this->percentChange7d;
    }

    public function getPercentChange24h(): float
    {
        return $this->percentChange24h;
    }

    public function setCirculatingSupply(int $circulatingSupply): void
    {
        $this->circulatingSupply = $circulatingSupply;
    }

    public function setPercentChange1h(float $percentChange1h): void
    {
        $this->percentChange1h = $percentChange1h;
    }

    public function setPercentChange7d(float $percentChange7d): void
    {
        $this->percentChange7d = $percentChange7d;
    }

    public function setPercentChange24h(float $percentChange24h): void
    {
        $this->percentChange24h = $percentChange24h;
    }

    public function getVolume24h(): float
    {
        return $this->volume24h;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
