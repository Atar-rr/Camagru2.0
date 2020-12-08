<?php


namespace App\Src\Controller;


use App\Src\Core\Controller;
use App\Src\Core\View;
use App\Src\Exception\UserUnauthorizedException;
use App\Src\Model\DTO\Setting\EmailEditDTO;
use App\Src\Model\DTO\Setting\LoginEditDTO;
use App\Src\Model\DTO\Setting\PasswordEditDTO;
use App\Src\Model\Module\Setting;

class SettingController extends Controller
{
    const MESSAGE_EMAIL_EDIT    = 'Ваш email изменен';
    const MESSAGE_LOGIN_EDIT    = 'Ваш логин изменен';
    const MESSAGE_PASSWORD_EDIT = 'Ваш пароль изменен';

    public function __construct(View $view, array $routes = [], ?string $query = '')
    {
        parent::__construct($view, $routes, $query);
        $this->model = new Setting();
    }

    public function emailEditAction(): void
    {
        $this->userIsLogin();

        if ($this->method === self::METHOD_POST) {
            try {
                $emailEditDto = (new EmailEditDTO())
                    ->setEmail($_POST[self::FIELD_USER][self::FIELD_EMAIL] ?? '');
                $this->model->emailEdit($emailEditDto);
                $this->result[self::SUCCESS] = self::MESSAGE_EMAIL_EDIT;
            } catch (\Exception $e) {
                $this->result[self::ERROR] = $e->getMessage();
            }
        }
        $this->result[self::FIELD_EMAIL] = $this->model->getEmail();

        $this->view->renderer('/setting/email.phtml', $this->result);
    }

    public function loginEditAction(): void
    {
        $this->userIsLogin();

        if ($this->method === self::METHOD_POST) {
            try {
                $loginEditDto = (new LoginEditDTO())
                    ->setLogin($_POST[self::FIELD_USER][self::FIELD_LOGIN] ?? '');
                $this->model->loginEdit($loginEditDto);
                $this->result[self::SUCCESS] = self::MESSAGE_LOGIN_EDIT;
            } catch (\Exception $e) {
                $this->result[self::ERROR] = $e->getMessage();
            }
        }
        $this->result[self::FIELD_LOGIN] = $this->model->getLogin();

        $this->view->renderer('/setting/login.phtml', $this->result);
    }

    public function passwordEditAction(): void
    {
        $this->userIsLogin();

        if ($this->method === self::METHOD_POST) {
            try {
                $passEditDto = (new PasswordEditDTO())
                    ->setOldPassword($_POST[self::FIELD_USER][self::FIELD_OLD_PASSWORD] ?? '')
                    ->setNewPassword($_POST[self::FIELD_USER][self::FIELD_NEW_PASSWORD] ?? '')
                    ->setConfirmPassword($_POST[self::FIELD_USER][self::FIELD_CONFIRM] ?? '');
                $this->model->passwordEdit($passEditDto);
                $this->result[self::SUCCESS] = self::MESSAGE_PASSWORD_EDIT;
            } catch (\Exception $e) {
                $this->result[self::ERROR] = $e->getMessage();
            }
        }

        $this->view->renderer('/setting/password.phtml', $this->result);
    }

    public function notifyAction()
    {
        $this->userIsLogin();

        if ($this->method === self::METHOD_POST) {
            try {
                $this->model->notifyChange($_POST['notify'] === "1" ? 0 : 1);
            } catch (\Exception $e) {
                $this->result[self::ERROR] = $e->getMessage();
            }
        } elseif ($this->method === self::METHOD_GET) {
            $this->result['notify'] = $this->model->getNotify();
            $this->view->renderer('/setting/notify.phtml', $this->result);
        }

    }
}
