<?php

namespace App\Models;

class NewUser
{
    private string $name;
    private string $email;
    private string $password;
    private string $confirmPassword;

    public function __construct(string $name, string $email, string $password, string $confirmPassword)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getConfirmPassword(): string
    {
        return $this->confirmPassword;
    }
}
