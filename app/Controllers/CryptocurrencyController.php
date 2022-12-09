<?php

namespace App\Controllers;

use App\Services\CryptocurrencyCollectionService;
use App\Template;

class CryptocurrencyController
{
    public function index():Template
    {
        $cryptocurrencyCollection=(new CryptocurrencyCollectionService())->execute(10);
        $cryptocurrencies=$cryptocurrencyCollection->getCryptocurrencyCollection();
        return new Template('index.twig',[
            'cryptocurrencies' => $cryptocurrencies
        ]);
    }
}
