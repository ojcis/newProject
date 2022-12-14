<?php

namespace App\Controllers;

use App\Models\Collections\UserCryptocurrencyCollection;
use App\Redirect;
use App\Services\SellService;
use App\Template;

class ValetController
{
    public function showForm(): Template
    {
        $userCryptocurrencyCollection=new UserCryptocurrencyCollection();
        return new Template('valet.twig', [
            'cryptocurrencies' => $userCryptocurrencyCollection->getUserCryptocurrencyCollection()
        ]);
    }

    public function sell(): Redirect
    {
        $userCryptocurrencyId=$_POST['cryptocurrencyId'];
        $amount=$_POST['amount'];
        $sellService=new SellService();
        $userCryptocurrencyAmount=$sellService->getUserCryptocurrencyAmount($userCryptocurrencyId);
        if ($amount>$userCryptocurrencyAmount){
            $_SESSION['error']['amount']="You have only $userCryptocurrencyAmount cryptocurrencies";
            return new Redirect('/valet');
        }
        $sellService->sell($userCryptocurrencyId,$amount);
        if ($amount==$userCryptocurrencyAmount){
            $sellService->deleteFromDataBase($userCryptocurrencyId);
        }else{
            $sellService->subtractFromDataBase($userCryptocurrencyId,$userCryptocurrencyAmount-$amount);
        }
        return new Redirect('/valet');
    }
}