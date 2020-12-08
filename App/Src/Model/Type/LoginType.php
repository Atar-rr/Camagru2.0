<?php


namespace App\Src\Model\Type;


use App\Src\Exception\ValidateException;
use App\Src\Model\Data\Row\UserRow;
use App\Src\Model\Data\TableDataGateway\UserGateway;

class LoginType extends BaseType
{
    /**
     * @param string $login
     * @throws ValidateException
     */
    public function validate(string $login)
    {
        if ($login === '') {
            throw new ValidateException('Поле логин не может быть пустым', 400);
        } elseif (!preg_match('/^([\wа-яА-Я])+(?!.*\W)$/', $login)) {
            throw new ValidateException('Вы ввели недопустимые символы. Логин может содержать буквы,
             цифры и символы нижнего подчеркивания', 400);
        } elseif (mb_strlen($login) < 3 ||  mb_strlen($login) > 20) {
            throw new ValidateException('Логин должен быть от 3 до 20 символов', 400);
        }
    }

    /**
     * @param string $login
     * @throws ValidateException
     */
    public function loginIsFree(string $login)
    {
        $userGateway = UserGateway::create();
        $userRow = UserRow::create();
        $userRow->setLogin($login);
        if ($userGateway->hasByLogin($userRow)) {
            throw new ValidateException('Пользователь с таким логином уже существует', 400);
        }
    }

    public static function create()
    {
        return new self();
    }
}