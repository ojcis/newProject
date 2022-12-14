<?php

namespace App\Models\Collections;

use App\DataBase;
use App\Models\UserCryptocurrency;
use App\Services\CryptocurrencyService;

class UserCryptocurrencyCollection
{
    private array $userCryptocurrencyCollection=[];

    public function __construct()
    {
        $queryBuilder=DataBase::getConnection()->createQueryBuilder();
        $userCryptocurrencies=$queryBuilder
            ->select('*')
            ->from('cryptocurrencies')
            ->where('user_id=?')
            ->setParameter(0,$_SESSION['userId'])
            ->fetchAllAssociative();
        $cryptocurrencyService=new CryptocurrencyService();
        foreach ($userCryptocurrencies as $userCryptocurrency){
            $symbol=$userCryptocurrency['symbol'];
            $priceNow=$cryptocurrencyService->execute($symbol)->getPrice();
            $this->userCryptocurrencyCollection[]= new UserCryptocurrency(
                $userCryptocurrency['id'],
                $symbol,
                $userCryptocurrency['price'],
                $userCryptocurrency['amount'],
                $priceNow
            );
        }
    }

    public function getUserCryptocurrencyCollection(): array
    {
        return $this->userCryptocurrencyCollection;
    }
}
