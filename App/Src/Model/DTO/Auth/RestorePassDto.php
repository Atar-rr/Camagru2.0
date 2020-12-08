<?php

namespace App\Src\Model\DTO\Auth;

class RestorePassDto
{
    protected $email;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return RestorePassDto
     */
    public function setEmail(string $email):  RestorePassDto
    {
        $this->email = $email;
        return $this;
    }
}