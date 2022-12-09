<?php

namespace App\Repositories;

use App\Models\Collections\CryptocurrencyCollection;

interface CryptocurrenciesRepository
{
    public function getCryptocurrencies(?int $limit=3, ?string $currency='EUR'): CryptocurrencyCollection;
}
