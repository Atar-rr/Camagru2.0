<?php

namespace App\Src\Controller;

use App\Src\Core\Controller;
use App\Src\Core\View;
use App\Src\Exception\UserUnauthorizedException;
use App\Src\Model\DTO\Auth\ActivateDto;
use App\Src\Model\DTO\Auth\LoginDto;
use App\Src\Model\DTO\Auth\RegistrationDto;
use App\Src\Model\DTO\Auth\RestorePassDto;
use App\Src\Model\DTO\Auth\UpdatePassDto;
use App\Src\Model\Module\Auth;

class AuthController extends Controller
{
    const MESSAGE_RESTORE = 'На указанный email отправлено письмо с инструкциями по сбросу пароля';
    const MESSAGE_RESET = 'Установлен новый пароль';
    const MESSAGE_ACTIVATE = 'Ваш аккаунт активирован';
    const MESSAGE_REG = 'Спасибо за регистрацию. Вам необходимо подтвердить ваш email. Для этого нужно перейти по ссылке которую мы отправили на ваш email';

    /**
     * AuthController constructor.
     *
     * @param View $view
     * @param array $routes
     * @param string|null $query
     */
    public function __construct(View $view, array $routes = [], ?string $query = '')
    {
        parent::__construct($view, $routes, $query);
        $this->model = new Auth();
    }

    /**
     * @return AuthController|void
     */
    public function loginAction(): void
    {
        try {
            $this->auth->checkUserLogin();
            $this->redirect('/');
        } catch (UserUnauthorizedException $e) {
        }

        if ($this->method === self::METHOD_POST) {
            $loginDto = (new LoginDto())
                ->setLogin($_POST[self::FIELD_USER][self::FIELD_LOGIN] ?? '')
                ->setPassword($_POST[self::FIELD_USER][self::FIELD_PASSWORD] ?? '')
            ;

            try {
                $this->model->login($loginDto);
            } catch (\Exception $e) {
                $this->result[self::ERROR] = $e->getMessage();
                $this->result[self::FIELD_USER] = $_POST[self::FIELD_USER];
                $this->view->renderer('/user/login.phtml', $this->result);
            }

            $this->redirect('/');
        } elseif ($this->method === self::METHOD_GET) {
            $this->view->renderer('/user/login.phtml', $this->result);
        }
    }

    /**
     * @return AuthController|void
     */
    public function registrationAction(): void
    {
        try {
            $this->auth->checkUserLogin();
            $this->redirect('/');
        } catch (UserUnauthorizedException $e) {
        }

        if ($this->method === self::METHOD_POST) {
            $registrationDto = (new RegistrationDto())
                ->setEmail($_POST[self::FIELD_USER][self::FIELD_EMAIL] ?? '')
                ->setLogin($_POST[self::FIELD_USER][self::FIELD_LOGIN] ?? '')
                ->setPassword($_POST[self::FIELD_USER][self::FIELD_PASSWORD] ?? '')
                ->setConfirmPassword($_POST[self::FIELD_USER][self::FIELD_CONFIRM] ?? '')
            ;

            try {
                $this->model->registration($registrationDto);
            } catch (\Exception $e) {
                $this->result = ['error' => $e->getMessage(), 'user' => $_POST[self::FIELD_USER]];
                $this->view->renderer('/user/registration.phtml', $this->result);
            }

            $_SESSION[self::SUCCESS] = self::MESSAGE_REG;
            $this->redirect('/auth/login');
        } elseif ($this->method === self::METHOD_GET) {
            $this->view->renderer('/user/registration.phtml');
        }
    }

    /**
     * Подвтерждение регистрации
     *
     * @return AuthController|void
     */
    public function activateAction()
    {
        try {
            $this->auth->checkUserLogin();
            $this->redirect('/');
        } catch (UserUnauthorizedException $e) {
        }

        if ($this->method === self::METHOD_GET) {
            $activateDto = (new ActivateDto())
                ->setToken($this->query[self::FIELD_TOKEN] ?? '')
            ;

            try {
                $this->model->activate($activateDto);
            } catch (\Exception $e) {
                $this->result[self::ERROR] = $e->getMessage();
                $this->view->renderer('/user/login.phtml', $this->result);
            }

            $_SESSION[self::SUCCESS] = self::MESSAGE_ACTIVATE;
            $this->redirect('/auth/login');
        }
    }

    /**
     * Восстановление пароля
     *
     * @return AuthController|void
     */
    public function resetAction()
    {
        try {
            $this->auth->checkUserLogin();
            $this->redirect('/');
        } catch (UserUnauthorizedException $e) {
        }

        if ($this->method === self::METHOD_POST) {
            $resetDto = (new UpdatePassDto())
                ->setNewPassword($_POST[self::FIELD_USER][self::FIELD_PASSWORD] ?? '')
                ->setConfirmPassword($_POST[self::FIELD_USER][self::FIELD_CONFIRM] ?? '')
                ->setToken($_POST[self::FIELD_USER][self::FIELD_TOKEN] ?? '')
            ;

            try {
                $this->model->updatePass($resetDto, 'reset');
            } catch (\Exception $e) {
                $this->result[self::ERROR] = $e->getMessage();
                $this->view->renderer('/user/reset.phtml', $this->result);
            }

            $_SESSION[self::SUCCESS] = self::MESSAGE_RESET;
            $this->redirect('/auth/login');
        } elseif ($this->method === self::METHOD_GET) {
            $this->result[self::FIELD_USER][self::FIELD_TOKEN] = $this->query[self::FIELD_TOKEN] ?? '';
            $this->view->renderer('/user/reset.phtml', $this->result);
        }
    }

    /**
     * Запрос восстановления пароля
     *
     * @return AuthController|void
     */
    public function restoreAction()
    {
        try {
            $this->auth->checkUserLogin();
            $this->redirect('/');
        } catch (UserUnauthorizedException $e) {
        }

        if ($this->method === self::METHOD_POST) {
            $resetDto = (new RestorePassDto())
                ->setEmail($_POST[self::FIELD_USER][self::FIELD_EMAIL] ?? '')
            ;

            try {
                $this->model->reqResetPass($resetDto);
            } catch (\Exception $e) {
                $this->result[self::ERROR] = $e->getMessage();
                $this->result[self::FIELD_USER] = $_POST[self::FIELD_USER];
                $this->view->renderer('/user/restore.phtml', $this->result);
            }

            $_SESSION[self::SUCCESS] = self::MESSAGE_RESTORE;
            $this->redirect('/auth/login');
        } elseif ($this->method === self::METHOD_GET) {
            $this->view->renderer('/user/restore.phtml');
        }
    }

    /**
     * @return AuthController|void
     */
    public function logoutAction()
    {
        try {
            $this->model->logout();
        } catch (\Exception $e) {
        }

        $this->redirect('/auth/login');
    }
}
