<?php

namespace App\Src\Model\DTO\Auth;

class RegistrationDto
{
    protected $email;

    protected $login;

    protected $password;

    protected $confirmPassword;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return RegistrationDto
     */
    public function setEmail(string $email): RegistrationDto
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
     * @return RegistrationDto
     */
    public function setLogin(string $login): RegistrationDto
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
     * @return RegistrationDto
     */
    public function setPassword(string $password): RegistrationDto
    {
        $this->password = trim($password);
        return $this;
    }

    /**
     * @param string $confirmPassword
     * @return RegistrationDto
     */
    public function setConfirmPassword(string $confirmPassword): RegistrationDto
    {
        $this->confirmPassword = trim($confirmPassword);
        return $this;
    }

    /**
     * @return string
     */
    public function getConfirmPassword(): string
    {
        return $this->confirmPassword;
    }
}