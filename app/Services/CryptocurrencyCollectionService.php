<?php

namespace App\Services;

use App\Models\Collections\CryptocurrencyCollection;
use App\Repositories\ApiCryptocurrenciesRepository;
use App\Repositories\CryptocurrenciesRepository;

class CryptocurrencyCollectionService
{
    private CryptocurrenciesRepository $cryptocurrencies;

    public function __construct()
    {
        $this->cryptocurrencies=new ApiCryptocurrenciesRepository();
    }

    public function execute(?int $limit=3, ?string $currency='EUR'): CryptocurrencyCollection
    {
        return $this->cryptocurrencies->getCryptocurrencies($limit, $currency);
    }
}
