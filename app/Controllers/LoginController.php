<?php

namespace App\Controllers;

use App\Redirect;
use App\Template;
use App\Validation;

class LoginController
{
    public function showForm(): Template
    {
        return new Template('login.twig');
    }

    public function login(): Redirect
    {
        $email=$_POST['email'];
        $password=$_POST['password'];
        $validation=new Validation();
        $id=$validation->ValidateEmail($email);
        if (!$id){
            $_SESSION['error']['email']='No registered user with this email!';
            return new Redirect('/login');
        }
        $_SESSION['user']['email']=$email;
        if (!$validation->ValidatePassword($id, $password)){
            $_SESSION['error']['password']='Wrong password';
            return new Redirect('/login');
        }
        $_SESSION['userId']=$id;
        return new Redirect('/');
    }

    public function logout():Redirect
    {
        unset($_SESSION['userId']);
        unset($_SESSION['user']);
        return new Redirect('/');
    }
}
