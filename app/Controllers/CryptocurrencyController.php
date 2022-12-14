<?php

namespace App\Controllers;

use App\DataBase;
use App\Models\Cryptocurrency;
use App\Redirect;
use App\Services\BuyService;
use App\Services\CryptocurrencyCollectionService;
use App\Services\CryptocurrencyService;
use App\Template;

class CryptocurrencyController
{
    public function index(): Template
    {
        $limit = 2;
        $currency = 'EUR';
        $symbol = $_GET['search'] ?? null;
        if ($symbol) {
            $cryptocurrency = (new cryptocurrencyService())->execute($symbol, $currency);
            $_SESSION['cryptocurrency']=$cryptocurrency;
            return new Template('index.twig', [
                'cryptocurrency' => $cryptocurrency,
                'search' => $symbol
            ]);
        }
        $cryptocurrencyCollection = (new CryptocurrencyCollectionService())->execute($limit, $currency);
        $cryptocurrencies = $cryptocurrencyCollection->getCryptocurrencyCollection();
        return new Template('index.twig', [
            'cryptocurrencies' => $cryptocurrencies,
        ]);
    }

    public function buy(): Redirect
    {
        $cryptocurrency=$_SESSION['cryptocurrency'];
        $amount=$_POST['amount'];
        $price=$amount*$cryptocurrency->getPrice();
        $buyService=new BuyService();
        $userMoney=$buyService->getUserMoney();
        if ($price>$userMoney){
            $_SESSION['error']['money']='Not enough money!';
            return new Redirect("/?search={$cryptocurrency->getSymbol()}");
        }
        $buyService->buy($userMoney,$price);
        $buyService->addToDataBase($cryptocurrency,$amount);
        return new Redirect('/valet');
    }
}
