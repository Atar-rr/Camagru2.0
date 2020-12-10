<?php

namespace App\Src\Model\Module ;

use App\Src\Exception\NotFoundException;
use App\Src\Exception\ValidateException;
use App\Src\Model\Data\Row\TokenActivateUserRow;
use App\Src\Model\Data\Row\TokenRestorePasswordRow;
use App\Src\Model\Data\Row\UserRow;
use App\Src\Model\Data\Row\UserSessionRow;
use App\Src\Model\Data\TableDataGateway\TokenActivateUserGateway;
use App\Src\Model\Data\TableDataGateway\TokenRestorePasswordGateway;
use App\Src\Model\Data\TableDataGateway\UserGateway;
use App\Src\Model\Data\TableDataGateway\UserSessionGateway;
use App\Src\Model\DTO\Auth\ActivateDto;
use App\Src\Model\DTO\Auth\RestorePassDto;
use App\Src\Model\DTO\Auth\UpdatePassDto;
use App\Src\Model\Service\Logger;
use App\Src\Model\Service\Mailer;
use App\Src\Model\Service\PasswordHash;
use App\Src\Model\Service\Tokenizer;
use App\Src\Model\Type\EmailType;
use App\Src\Model\Type\PasswordType;
use App\Src\Model\DTO\Auth\LoginDto;
use App\Src\Model\DTO\Auth\RegistrationDto;

class Auth
{
    const
        USER_ACTIVE = true,
        UUID = 'uuid'
    ;

    protected $emailType;

    protected $passwordType;

    protected $userRow;

    protected $userGateway;

    protected $tokenActivateUserGateway;

    protected $tokenActivateUserRow;

    protected $restorePasswordGateway;

    protected $restorePasswordRow;

    protected $userSessionGateway;

    protected $userSessionRow;

    protected $logger;

    public function __construct()
    {
        $this->emailType = EmailType::create();
        $this->passwordType = PasswordType::create();
        $this->userRow = UserRow::create();
        $this->userGateway = UserGateway::create();
        $this->tokenActivateUserGateway = TokenActivateUserGateway::create();
        $this->tokenActivateUserRow = TokenActivateUserRow::create();
        $this->restorePasswordGateway = TokenRestorePasswordGateway::create();
        $this->restorePasswordRow = TokenRestorePasswordRow::create();
        $this->userSessionGateway = UserSessionGateway::create();
        $this->userSessionRow = UserSessionRow::create();
        $this->logger = Logger::create();
    }

    /**
     * @param LoginDto $loginInfo
     * @throws NotFoundException
     * @throws ValidateException
     */
    public function login(LoginDto $loginInfo)
    {
        $this->userRow->setLogin($loginInfo->getLogin());
        $this->userGateway->getByEmailOrLogin($this->userRow);
        $userId = $this->userRow->getId();

        if ($userId === null) {
            throw new NotFoundException('Пользователь с таким email не зарегистрирован', 404);
        }
        if (!$this->passwordType->verify($loginInfo->getPassword(), $this->userRow->getPassword())) {
            throw new ValidateException('Неверный пароль', 400);
        }
        if ($this->userRow->getActiveStatus() !== self::USER_ACTIVE) {
            throw new ValidateException('Аккаунт не активирован', 400);
        }

        $token = Tokenizer::generate(20) . '.' . $userId;
        $this->logger->authenticate($token);
        $this->userSessionRow
            ->setUserId($userId)
            ->setToken($token)
        ;
        $this->userSessionGateway->save($this->userSessionRow);
    }

    public function logout()
    {
        $token = $_SESSION[self::UUID] ?? '';
        $_SESSION = [];
        session_destroy();
        setcookie(self::UUID, '', time() - 86400, '/');
        $this->userSessionRow->setToken($token);
        $this->userSessionGateway->deleteByToken($this->userSessionRow);
    }

    /**
     * @param RegistrationDto $regInfo
     * @throws ValidateException
     */
    public function registration(RegistrationDto $regInfo)
    {
        $email = $regInfo->getEmail();
        $password = $regInfo->getPassword();

        $this->emailType->validate($email);
        $this->emailType->emailIsFree($email);
        $this->passwordType->validate($password, $regInfo->getConfirmPassword());

        $this->userRow->setEmail($email);
        $this->userRow->setLogin($regInfo->getLogin());
        $this->userRow->setPassword(PasswordHash::hash($password));
        $this->userGateway->save($this->userRow);

        $this->tokenActivateUserRow
            ->setToken(Tokenizer::generate())
            ->setUserId($this->userRow->getId());
        $this->tokenActivateUserGateway->save($this->tokenActivateUserRow);
        $this->sendRegMail($email, $this->tokenActivateUserRow->getToken());
    }

    /**
     * Метод отвечает за активацию аккаунта пользователя
     *
     * @param ActivateDto $activateDto
     * @throws NotFoundException
     */
    public function activate(ActivateDto $activateDto)
    {
        $this->tokenActivateUserRow->setToken($activateDto->getToken());
        $this->tokenActivateUserGateway->selectByToken($this->tokenActivateUserRow);
        if ($this->tokenActivateUserRow->getId() === null) {
            throw new NotFoundException('Ссылка для активации пользователя не действительна', 404);
        }

        $this->userRow
            ->setId($this->tokenActivateUserRow->getUserId())
            ->setActiveStatus(true);
        $this->userGateway->activateUser($this->userRow);
    }

    /**
     * Запрос на смену пароля
     *
     * @param RestorePassDto $info
     * @throws NotFoundException
     * @throws ValidateException
     */
    public function reqResetPass(RestorePassDto $info)
    {
        $email = $info->getEmail();

        $this->emailType->validate($email);
        $this->userRow->setEmail($email);

        $this->userGateway->getByEmail($this->userRow);
        if ($this->userRow->getId() === null) {
            throw new NotFoundException('Пользователя с таким Email не существует');
        }

        $this->restorePasswordRow
            ->setUserId($this->userRow->getId())
            ->setToken(Tokenizer::generate());

        $this->restorePasswordGateway->save($this->restorePasswordRow);
        $this->sendResetMail($email, $this->restorePasswordRow->getToken());
    }

    /**
     * @param UpdatePassDto $info
     * @param string $options
     * @throws NotFoundException
     * @throws ValidateException
     */
    public function updatePass(UpdatePassDto $info, string $options)
    {
        $password = $info->getNewPassword();

        $this->restorePasswordRow->setToken($info->getToken());
        $this->restorePasswordGateway->selectByToken($this->restorePasswordRow);
        if ($this->restorePasswordRow->getId() === null) {
            throw new NotFoundException(
                'Ссылка для восстановления пароля неверна. Запросите ссылку повторно', 404
            );
        }

        $this->passwordType->validate($password, $info->getConfirmPassword());
        $this->restorePasswordGateway->delete($this->restorePasswordRow);

        $passHash = PasswordHash::hash($password);
        $this->userRow
            ->setId($this->restorePasswordRow->getUserId())
            ->setPassword($passHash);

        $this->userGateway->updatePasswordById($this->userRow);
        $this->userSessionRow->setUserId($this->userRow->getId());
        $this->userSessionGateway->deleteByUserId($this->userSessionRow);
    }

    /**
     * @param string $email
     * @param string $token
     */
    private function sendResetMail(string $email, string $token)
    {
        $title = 'Восстановление пароля на сайте Camagru';
        $body = "Для восставноления пароля перейдите по ссылке
                       http://localhost:8080/auth/reset?token={$token}";

        Mailer::sendMail($email, $title, $body);
    }

    /**
     * @param string $email
     * @param string $token
     */
    private function sendRegMail(string $email, string $token)
    {
        $title = 'Подтверждение регистрации Camagru';
        $body = "Спасибо за регистрацию на сайте Camagru. Для подтверждения вашего аккаунта перейдите по ссылке 
                       http://localhost:8080/auth/activate?token={$token}";

        Mailer::sendMail($email, $title, $body);
    }
}
