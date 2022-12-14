<?php

namespace App\Services;

use App\DataBase;

class SellService
{
    public function getUserCryptocurrencyAmount(int $userCryptocurrencyId): int
    {
        $queryBuilder=DataBase::getConnection()->createQueryBuilder();
        return $queryBuilder
            ->select('amount')
            ->from('cryptocurrencies')
            ->where('id=?')
            ->setParameter(0,$userCryptocurrencyId)
            ->fetchOne();
    }

    public function deleteFromDataBase(int $userCryptocurrencyId): void
    {
        $dataBase=DataBase::getConnection();
        $dataBase->delete(
            'cryptocurrencies',
            ['id' => $userCryptocurrencyId]
        );
    }

    public function subtractFromDataBase(int $userCryptocurrencyId, int $amount): void
    {
        $dataBase=DataBase::getConnection();
        $dataBase->update(
            'cryptocurrencies',
            ['amount' => $amount],
            ['id' => $userCryptocurrencyId]
        );
    }

    public function sell(int $userCryptocurrencyId, int $amount): void
    {
        $dataBase=DataBase::getConnection();
        $queryBuilder=$dataBase->createQueryBuilder();
        $userCryptocurrency=$queryBuilder
            ->select('*')
            ->from('cryptocurrencies')
            ->where('id=?')
            ->setParameter(0,$userCryptocurrencyId)
            ->fetchAssociative();
        $priceNow=(new CryptocurrencyService())->execute($userCryptocurrency['symbol'])->getPrice();
        $money=$amount*$priceNow;
        $queryBuilder=$dataBase->createQueryBuilder();
        $userMoney=$queryBuilder
            ->select('money')
            ->from('users')
            ->where('id=?')
            ->setParameter(0,$_SESSION['userId'])
            ->fetchOne();
        $userMoney+=$money;
        $dataBase->update(
            'users',
            ['money' => $userMoney],
            ['id' => $_SESSION['userId']]
        );
    }
}
