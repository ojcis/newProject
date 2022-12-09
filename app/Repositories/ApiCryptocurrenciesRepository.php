<?php

namespace App\Repositories;

use App\Models\Collections\CryptocurrencyCollection;
use App\Models\Cryptocurrency;
use CoinMarketCap\Api;

class ApiCryptocurrenciesRepository implements CryptocurrenciesRepository
{
    public function getCryptocurrencies(?int $limit = 3, ?string $currency = 'EUR'): CryptocurrencyCollection
    {
        $cryptocurrencyCollection=new CryptocurrencyCollection();
        $cmc = new Api($_ENV['API_KEY']);
        $cryptocurrencies = $cmc->cryptocurrency()->listingsLatest(['limit' => $limit, 'convert' => $currency])->data;
        foreach ($cryptocurrencies as $cryptocurrency){
            $symbol=$cryptocurrency->symbol;
            $id=$cryptocurrency->id;
            //$cryptocurrenciesInfo=$cmc->cryptocurrency()->info(['symbol' => $symbol])->data->BTC;
            //echo "<pre>";
            //var_dump($cryptocurrenciesInfo);die;
            $cryptocurrencyCollection->add(new Cryptocurrency(
                $cryptocurrency->id,
                $cryptocurrency->name,
                $cryptocurrency->quote->EUR->price
            ));
        }

        return $cryptocurrencyCollection;
    }
}
