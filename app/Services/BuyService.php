<?php

namespace App\Services;

use App\DataBase;
use App\Models\Cryptocurrency;

class BuyService
{
    function getUserMoney(): float
    {
        $queryBuilder=DataBase::getConnection()->createQueryBuilder();
        return $queryBuilder
            ->select('money')
            ->from('users')
            ->where('id=?')
            ->setParameter(0,$_SESSION['userId'])
            ->fetchOne();
    }

    function addToDataBase(Cryptocurrency $cryptocurrency, int $amount): void
    {
        $dataBase=DataBase::getConnection();
        $dataBase->insert('cryptocurrencies', [
            'symbol' => $cryptocurrency->getSymbol(),
            'price' => $cryptocurrency->getPrice(),
            'amount' => $amount,
            'user_id' => $_SESSION['userId']
        ]);
    }

    function buy(float $userMoney, float $price): void
    {
        $change=$userMoney-$price;
        $dataBase=DataBase::getConnection();
        $dataBase->update(
            'users',
            ['money' => $change],
            ['id' => $_SESSION['userId']]
        );
    }
}
