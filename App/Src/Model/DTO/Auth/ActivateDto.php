<?php

namespace App\Src\Model\DTO\Auth;

class ActivateDto
{
    protected $token;

    /**
     * @param string $token
     * @return $this
     */
    public function setToken(string $token): ActivateDto
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}