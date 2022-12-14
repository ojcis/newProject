<?php

namespace App\Services;

use App\DataBase;

class ProfileService
{
    public function addMoney(float $addMoney): void
    {
        $dataBase=DataBase::getConnection();
        $queryBuilder=$dataBase->createQueryBuilder();
        $userMoney=$queryBuilder
            ->select('money')
            ->from('users')
            ->where('id=?')
            ->setParameter(0,$_SESSION['userId'])
            ->fetchOne();
        $userMoney+=$addMoney;
        $dataBase->update(
            'users',
            ['money' => $userMoney],
            ['id' => $_SESSION['userId']]
        );
    }

    public function changeName(string $name): void
    {
        $dataBase=DataBase::getConnection();
        $dataBase->update(
            'users',
            ['name' => $name],
            ['id' => $_SESSION['userId']]
        );
    }

    public function changeEmail(string $email): void
    {
        $dataBase=DataBase::getConnection();
        $dataBase->update(
            'users',
            ['email' => $email],
            ['id' => $_SESSION['userId']]
        );
    }

    public function changePassword(string $password): void
    {
        $dataBase=DataBase::getConnection();
        $dataBase->update(
            'users',
            ['password' => password_hash($password,PASSWORD_DEFAULT)],
            ['id' => $_SESSION['userId']]
        );
    }

    public function deleteAccount(): void
    {
        $dataBase=DataBase::getConnection();
        $dataBase->delete(
            'users',
            ['id' => $_SESSION['userId']]
        );
    }
}
