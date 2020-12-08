<?php

namespace App\Src\Model\Type;

use App\Src\Exception\ValidateException;

class PasswordType extends BaseType
{
    public static function create()
    {
        return new self();
    }

    /**
     * @param string $password
     * @param string $confirmPassword
     * @throws ValidateException
     */
    public function validate(string $password, string $confirmPassword)
    {
        if ($password === '') {
            throw new ValidateException('Поле password не может быть пустым', 400);
        }

        if (strcmp($password, $confirmPassword) !== 0) {
            throw new ValidateException('Пароли не совпадают', 400);
        }

        if (!preg_match('/^(?=.{8,255}$)((?=.*\d))(?!.*\W)(?=.*[a-z])(?=.*[A-Z]).+$/', $password)) {
            throw new ValidateException(
                "Вы ввели недопустимые символы. 
                Пароль должен содержать цифры и буквы латинского алфавита в верхнем и нижнем регистре.",
                400
            );
        }
    }

    public function verify(string $password, string $hash)
    {
        return password_verify($password, $hash);
    }
}
