<?php

namespace App\Src\Model\Type;

use App\Src\Exception\ValidateException;
use App\Src\Model\Data\Row\UserRow;
use App\Src\Model\Data\TableDataGateway\UserGateway;

class EmailType extends BaseType
{
    /**
     * @param string $email
     * @throws ValidateException
     */
    public function validate(string $email): void
    {
        if ($email === '') {
            throw new ValidateException('Поле email не может быть пустым', 400);
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new ValidateException('Некорректный email адрес', 400);
        }
    }


    /**
     * @param string $email
     * @throws ValidateException
     */
    public function emailIsFree(string $email): void
    {
        $userGateway = UserGateway::create();
        $userRow = UserRow::create();
        $userRow->setEmail($email);
        if ($userGateway->hasByEmail($userRow)) {
            throw new ValidateException('Пользователь с таким email существует', 400);
        }
    }

    /**
     * @return EmailType
     */
    public static function create(): EmailType
    {
        return new self();
    }
}
