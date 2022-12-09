<?php

namespace App;

class Validation
{
    public function ValidateEmail(string $email): ?int
    {
        $queryBuilder=DataBase::getConnection()->createQueryBuilder();
        $userId=$queryBuilder
            ->select('id')
            ->from('users')
            ->where('email=?')
            ->setParameter(0,$email)
            ->fetchOne();
        return ($userId);
    }

    public function comparePasswords(string $password1, string $password2): bool
    {
        return ($password1==$password2);
    }

    public function ValidatePassword(int $id, string $password): bool
    {
        $queryBuilder=DataBase::getConnection()->createQueryBuilder();
        $userPassword=$queryBuilder
            ->select('password')
            ->from('users')
            ->where('id=?')
            ->setParameter(0,$id)
            ->fetchOne();
        return password_verify($password, $userPassword);
    }
}
