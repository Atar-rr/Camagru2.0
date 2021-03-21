<?php

namespace App\Src\Model\DTO\Setting;

class PasswordEditDTO
{
    protected $newPassword;

    protected $oldPassword;

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
     * @return PasswordEditDTO
     */
    public function setNewPassword(string $newPassword): PasswordEditDTO
    {
        $this->newPassword = trim($newPassword);
        return $this;
    }

    /**
     * @param string $confirmPassword
     * @return PasswordEditDTO
     */
    public function setConfirmPassword(string $confirmPassword): PasswordEditDTO
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
    public function getOldPassword()
    {
        return $this->oldPassword;
    }

    /**
     * @param string $oldPassword
     * @return PasswordEditDTO
     */
    public function setOldPassword(string $oldPassword): PasswordEditDTO
    {
        $this->oldPassword = $oldPassword;
        return $this;
    }
}
