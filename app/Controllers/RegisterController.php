<?php

namespace App\Controllers;

use App\DataBase;
use App\Models\NewUser;
use App\Redirect;
use App\Services\RegisterService;
use App\Template;
use App\Validation;

class RegisterController
{
    public function showForm(): Template
    {
        return new Template('register.twig');
    }

    public function register(): Redirect
    {
        $newUser=new NewUser($_POST['name'],$_POST['email'],$_POST['password'],$_POST['confirmPassword']);
        $_SESSION['user']['name']=$newUser->getName();
        $validation=new Validation();
        $id=$validation->ValidateEmail($newUser->getEmail());
        if ($id){
            $_SESSION['error']['email']='This email is already used!';
            return New Redirect('/register');
        }
        $_SESSION['user']['email']=$newUser->getEmail();
        if (!$validation->comparePasswords($newUser->getPassword(),$newUser->getConfirmPassword())){
            $_SESSION['error']['password']='Passwords does not mach!';
            return New Redirect('/register');
        }
        $registerService=new RegisterService();
        $registerService->addToDataBase($newUser);
        $_SESSION['userId']=$validation->ValidateEmail($newUser->getEmail());
        return New Redirect('/');
    }
}
