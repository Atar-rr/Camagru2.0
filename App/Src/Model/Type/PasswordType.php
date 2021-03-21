<?php

namespace App\Src\Model\Type;

use App\Src\Exception\ValidateException;

class PasswordType extends BaseType
{
    /**
     * @return PasswordType
     */
    public static function create(): PasswordType
    {
        return new self();
    }

    /**
     * @param string $password
     * @param string $confirmPassword
     * @throws ValidateException
     */
    public function validate(string $password, string $confirmPassword): void
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

    /**
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
