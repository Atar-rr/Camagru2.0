<?php

namespace App\Src\Model\DTO\Setting;

class LoginEditDTO
{
    protected $login;

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param string $login
     * @return LoginEditDTO
     */
    public function setLogin(string $login): LoginEditDTO
    {
        $this->login = $login;
        return $this;
    }
}
