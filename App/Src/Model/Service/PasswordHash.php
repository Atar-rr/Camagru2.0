<?php

namespace App\Src\Model\Service;

class PasswordHash
{
    public static function hash(string $password)
    {
        return password_hash($password, PASSWORD_ARGON2ID);
    }
}