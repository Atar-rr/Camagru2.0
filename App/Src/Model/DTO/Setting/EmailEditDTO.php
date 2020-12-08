<?php

namespace App\Src\Model\DTO\Setting;

class EmailEditDTO
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
     * @return EmailEditDTO
     */
    public function setEmail(string $email): EmailEditDTO
    {
        $this->email = $email;
        return $this;
    }
}
