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
            $cryptocurrencyInfo=$cmc->cryptocurrency()->info(['symbol' => $symbol])->data->{$symbol};
            $cryptocurrencyCollection->add(new Cryptocurrency(
                $symbol,
                $cryptocurrency->name,
                $cryptocurrency->circulating_supply,
                $cryptocurrency->quote->{$currency}->price,
                $cryptocurrency->quote->{$currency}->percent_change_1h,
                $cryptocurrency->quote->{$currency}->percent_change_24h,
                $cryptocurrency->quote->{$currency}->percent_change_7d,
                $cryptocurrency->quote->{$currency}->volume_24h,
                $cryptocurrencyInfo->urls->website[0],
                $cryptocurrencyInfo->description,
                $cryptocurrencyInfo->logo,
                $currency
            ));
        }

        return $cryptocurrencyCollection;
    }

    public function getCryptocurrency(string $symbol, ?string $currency='EUR'): Cryptocurrency
    {
        $cmc = new Api($_ENV['API_KEY']);
        $cryptocurrencyInfo=$cmc->cryptocurrency()->info(['symbol' => $symbol])->data->{$symbol};
        $cryptocurrency=$cmc->cryptocurrency()->quotesLatest(['symbol' => $symbol, 'convert' => $currency])->data->{$symbol};
        return new Cryptocurrency(
            $symbol,
            $cryptocurrency->name,
            $cryptocurrency->circulating_supply,
            $cryptocurrency->quote->{$currency}->price,
            $cryptocurrency->quote->{$currency}->percent_change_1h,
            $cryptocurrency->quote->{$currency}->percent_change_24h,
            $cryptocurrency->quote->{$currency}->percent_change_7d,
            $cryptocurrency->quote->{$currency}->volume_24h,
            $cryptocurrencyInfo->urls->website[0],
            $cryptocurrencyInfo->description,
            $cryptocurrencyInfo->logo,
            $currency
        );
    }
}