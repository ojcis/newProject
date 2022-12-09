<?php

namespace App\Models\Collections;

use App\Models\Cryptocurrency;
use CoinMarketCap\Api;

class CryptocurrencyCollection
{
    private array $cryptocurrencyCollection;

    public function __construct()
    {
        $this->cryptocurrencyCollection=[];
    }

    public function add(Cryptocurrency $cryptocurrency)
    {
        $this->cryptocurrencyCollection[]=$cryptocurrency;
    }

    public function getCryptocurrencyCollection(): array
    {
        return $this->cryptocurrencyCollection;
    }
}
