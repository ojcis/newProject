<?php

namespace App\Controllers;

use App\Redirect;
use App\Services\ProfileService;
use App\Template;
use App\Validation;

class ProfileController
{
    public function showForm(): Template
    {
        $update = $_GET['update'] ?? false;
        return new Template('profile.twig',[
            $update => true,
        ]);
    }

    public function addMoney(): Redirect
    {
        $moneyAmount=$_POST['addMoney'];
        $profileService=new ProfileService();
        $profileService->addMoney($moneyAmount);
        return new Redirect('/profile');
    }

    public function changeName(): Redirect
    {
        $password=$_POST['password'];
        $newName=$_POST['name'];
        $validation=new Validation();
        $_SESSION['user']['newName']=$newName;
        if (!$validation->ValidatePassword($_SESSION['userId'], $password)){
            $_SESSION['error']['password']='Wrong password';
            return new Redirect('/profile?update=changeName');
        }
        $profileService=new ProfileService();
        $profileService->changeName($newName);
        return new Redirect('/profile');
    }

    public function changeEmail(): Redirect
    {
        $password=$_POST['password'];
        $newEmail=$_POST['email'];
        $validation=new Validation();
        $id=$validation->ValidateEmail($newEmail);
        if ($id){
            $_SESSION['error']['email']='This email is already taken!';
            return new Redirect('/profile?update=changeEmail');
        }
        $_SESSION['user']['newEmail']=$newEmail;
        if (!$validation->ValidatePassword($_SESSION['userId'], $password)){
            $_SESSION['error']['password']='Wrong password';
            return new Redirect('/profile?update=changeEmail');
        }
        $profileService=new ProfileService();
        $profileService->changeEmail($newEmail);
        return new Redirect('/profile');
    }

    public function changePassword(): Redirect
    {
        $password=$_POST['password'];
        $newPassword=$_POST['newPassword'];
        $confirmNewPassword=$_POST['checkNewPassword'];
        $validation=new Validation();
        if (!$validation->ValidatePassword($_SESSION['userId'], $password)){
            $_SESSION['error']['password']='Wrong password';
            return new Redirect('/profile?update=changePassword');
        }
        if (!$validation->comparePasswords($newPassword,$confirmNewPassword)){
            $_SESSION['error']['newPassword']='Passwords does not mach';
            return new Redirect('/profile?update=changePassword');
        }
        $profileService=new ProfileService();
        $profileService->changePassword($newPassword);
        return new Redirect('/profile');
    }

    public function deleteAccount(): Redirect
    {
        $password=$_POST['password'];
        $validation=new Validation();
        if (!$validation->ValidatePassword($_SESSION['userId'], $password)){
            $_SESSION['error']['password']='Wrong password';
            return new Redirect('/profile?update=deleteAccount');
        }
        $profileService=new ProfileService();
        $profileService->deleteAccount();
        unset($_SESSION['userId']);
        return new Redirect('/');

    }
}
