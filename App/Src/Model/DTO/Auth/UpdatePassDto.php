<?php

namespace App\Src\Model\DTO\Auth;

class UpdatePassDto
{
    protected $newPassword;

    protected $token;

    protected $confirmPassword;

    /**
     * @return string
     */
    public function getNewPassword(): string
    {
        return $this->newPassword;
    }

    /**
     * @param string $newPassword
     * @return UpdatePassDto
     */
    public function setNewPassword(string $newPassword):UpdatePassDto
    {
        $this->newPassword = trim($newPassword);
        return $this;
    }

    /**
     * @param string $confirmPassword
     * @return UpdatePassDto
     */
    public function setConfirmPassword(string $confirmPassword): UpdatePassDto
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

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return UpdatePassDto
     */
    public function setToken(string $token): UpdatePassDto
    {
        $this->token = $token;
        return $this;
    }
}