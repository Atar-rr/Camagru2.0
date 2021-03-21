<?php

namespace App\Src\Model\Service;

use App\Src\Exception\UserUnauthorizedException;
use App\Src\Model\Data\Row\UserSessionRow;
use App\Src\Model\Data\TableDataGateway\UserSessionGateway;

class Auth
{
    protected const UUID = 'uuid';

    protected $userSessionGateway;

    protected $userSessionRow;

    /**
     * Auth constructor.
     */
    public function __construct()
    {
        $this->userSessionGateway = UserSessionGateway::create();
        $this->userSessionRow = UserSessionRow::create();
    }

    /**
     * @return Auth
     */
    public static function create(): Auth
    {
        return new self();
    }

    /**
     * @throws UserUnauthorizedException
     */
    public function checkUserLogin(): void
    {
        if (isset($_SESSION[self::UUID])) {
            $this->setCookie($_SESSION[self::UUID]);
        } elseif (isset($_COOKIE[self::UUID])) {
            $uuid = $_COOKIE[self::UUID];
            $this->userSessionRow->setToken($uuid);
            $this->userSessionGateway->selectByToken($this->userSessionRow);
            if ($this->userSessionRow->getId() === null) {
                throw new UserUnauthorizedException('Пользователь не авторизован');
            }
            $this->authenticate($uuid);
        } else {
            throw new UserUnauthorizedException('Пользователь не авторизован');
        }
    }

    /**
     * Возвраает id юзера из сессии
     *
     * @return int|null
     */
    public static function getUserIdFromSession(): ?int
    {
        $uuid = $_SESSION[self::UUID] ?? null;
        if ($uuid === null) {
            return null;
        }

        return explode('.', $uuid)[1] ?? null;
    }

    /**
     * @param string $token
     */
    public function authenticate(string $token): void
    {
        $this->setSession($token);
        $this->setCookie($token);
    }

    /**
     * @param string $token
     */
    private function setSession(string $token): void
    {
        $_SESSION[self::UUID] = $token;
    }

    /**
     * @param string $token
     */
    private function setCookie(string $token): void
    {
        setcookie(self::UUID, $token, time() + 86400, '/');
    }
}
