<?php

namespace App\Services;

use App\Models\Cryptocurrency;
use App\Repositories\ApiCryptocurrenciesRepository;
use App\Repositories\CryptocurrenciesRepository;

class CryptocurrencyService
{
    private CryptocurrenciesRepository $cryptocurrency;

    public function __construct()
    {
        $this->cryptocurrency=new ApiCryptocurrenciesRepository();
    }

    public function execute(string $symbol, ?string $currency='EUR'): Cryptocurrency
    {
        return $this->cryptocurrency->getCryptocurrency($symbol,$currency);
    }


}
