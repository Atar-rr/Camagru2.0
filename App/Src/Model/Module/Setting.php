<?php

namespace App\Src\Model\Module;

use App\Src\Exception\ValidateException;
use App\Src\Model\Data\Row\UserRow;
use App\Src\Model\Data\TableDataGateway\UserGateway;
use App\Src\Model\DTO\Setting\EmailEditDTO;
use App\Src\Model\DTO\Setting\LoginEditDTO;
use App\Src\Model\DTO\Setting\PasswordEditDTO;
use App\Src\Model\Service\Logger;
use App\Src\Model\Service\PasswordHash;
use App\Src\Model\Type\EmailType;
use App\Src\Model\Type\LoginType;
use App\Src\Model\Type\PasswordType;

class Setting
{
    protected $emailType;

    protected $passwordType;

    protected $loginType;

    protected $userRow;

    protected $userGateway;

    protected $logger;

    public function __construct()
    {
        $this->emailType = EmailType::create();
        $this->passwordType = PasswordType::create();
        $this->loginType = LoginType::create();
        $this->userRow = UserRow::create();
        $this->userGateway = UserGateway::create();
        $this->logger = Logger::create();
    }

    /**
     * @param EmailEditDTO $emailEditDto
     * @throws \App\Src\Exception\ValidateException
     */
    public function emailEdit(EmailEditDTO $emailEditDto)
    {
        $email = $emailEditDto->getEmail();

        $this->emailType->validate($email);
        $this->emailType->emailIsFree($email);

        $userId = Logger::getUserIdFromSession();

        $this->userRow->setId($userId);

        /** @var UserRow $user */
        $user = $this->userGateway->getRow($this->userRow);
        $user->setEmail($email);

        $this->userGateway->update($user);
    }

    /**
     * @param LoginEditDTO $loginEditDto
     * @throws \App\Src\Exception\ValidateException
     */
    public function loginEdit(LoginEditDTO $loginEditDto)
    {
        $login = $loginEditDto->getLogin();

        $this->loginType->validate($login);
        $this->loginType->loginIsFree($login);

        $userId = Logger::getUserIdFromSession();

        $this->userRow->setId($userId);

        /** @var UserRow $user */
        $user = $this->userGateway->getRow($this->userRow);
        $user->setLogin($login);

        $this->userGateway->update($user);
    }

    /**
     * @param PasswordEditDTO $passwordEditDto
     * @throws ValidateException
     */
    public function passwordEdit(PasswordEditDTO $passwordEditDto)
    {
        $newPassword = $passwordEditDto->getNewPassword();
        $userId = Logger::getUserIdFromSession();
        $this->userRow->setId($userId);

        /** @var UserRow $user */
        $user = $this->userGateway->getRow($this->userRow);

        if ($this->passwordType->verify($passwordEditDto->getOldPassword(), $user->getPassword()) === false) {
            throw new ValidateException('Старый пароль неверен');
        }

        $this->passwordType->validate($newPassword, $passwordEditDto->getConfirmPassword());
        $user->setPassword(PasswordHash::hash($newPassword));

        $this->userGateway->update($user);
    }

    public function notifyChange(int $notify)
    {
        $userId = Logger::getUserIdFromSession();
        $this->userRow->setId($userId);

        /** @var UserRow $user */
        $user = $this->userGateway->getRow($this->userRow);

        $user->setNotify($notify);
        $this->userGateway->save($user);
    }

    public function getNotify(): string
    {
        $userId = Logger::getUserIdFromSession();
        $this->userRow->setId($userId);

        /** @var UserRow $user */
        $user = $this->userGateway->getRow($this->userRow);

        return $user->getNotify();
    }

    public function getEmail(): string
    {
        $userId = Logger::getUserIdFromSession();
        $this->userRow->setId($userId);

        /** @var UserRow $user */
        $user = $this->userGateway->getRow($this->userRow);

        return $user->getEmail();
    }

    public function getLogin(): string
    {
        $userId = Logger::getUserIdFromSession();
        $this->userRow->setId($userId);

        /** @var UserRow $user */
        $user = $this->userGateway->getRow($this->userRow);

        return $user->getLogin();
    }
}
