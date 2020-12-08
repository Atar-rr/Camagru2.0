<?php

namespace App\Src\Model\DTO\Auth;

#TODO может переназвать на form?
class LoginDto
{
    protected $email;

    protected $login;

    protected $password;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return LoginDto
     */
    public function setEmail(string $email): LoginDto
    {
        $this->email = trim($email);
        return $this;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     * @return LoginDto
     */
    public function setLogin(string $login): LoginDto
    {
        $this->login = trim($login);
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return LoginDto
     */
    public function setPassword(string $password): LoginDto
    {
        $this->password = trim($password);
        return $this;
    }
}
