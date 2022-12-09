<?php

namespace App\ViewVariables;

use App\DataBase;

class UserViewVariables implements ViewVariables
{
    public function getName(): string
    {
        return 'user';
    }

    public function getValue(): array
    {
        if (!$_SESSION['userId']) {
            return $_SESSION['user'] ?? [];
        }
        $queryBuilder=DataBase::getConnection()->createQueryBuilder();
        $user=$queryBuilder
            ->select('*')
            ->from('users')
            ->where('id=?')
            ->setParameter(0,$_SESSION['userId'])
            ->fetchAssociative();
        return [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email']
        ];
    }
}
