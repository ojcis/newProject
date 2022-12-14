<?php

namespace App\Repositories;

use App\Models\Collections\CryptocurrencyCollection;
use App\Models\Cryptocurrency;

interface CryptocurrenciesRepository
{
    public function getCryptocurrencies(?int $limit=3, ?string $currency='EUR'): CryptocurrencyCollection;
    public function getCryptocurrency(string $symbol, ?string $currency = 'EUR'): Cryptocurrency;
}
