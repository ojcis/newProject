<?php

namespace App\Services;

use App\DataBase;
use App\Models\NewUser;

class RegisterService
{
    public function addToDataBase(NewUser $newUser)
    {
        $dataBase=DataBase::getConnection();
        $dataBase->insert('users', [
            'name' => $newUser->getName(),
            'email' => $newUser->getEmail(),
            'password' => password_hash($newUser->getPassword(),PASSWORD_DEFAULT)
        ]);
    }
}
