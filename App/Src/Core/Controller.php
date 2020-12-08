<?php

namespace App\Src\Core;

use App\Src\FieldsConst;
use App\Src\Model\Service\Logger;

/**
 * Class Controller
 * @package App\core
 *
 * @method \App\Src\Controller\AuthController loginAction()
 * @method \App\Src\Controller\AuthController registrationAction()
 * @method \App\Src\Controller\AuthController activateAction()
 * @method \App\Src\Controller\AuthController resetAction()
 * @method \App\Src\Controller\AuthController restoreAction()
 * @method \App\Src\Controller\AuthController logoutAction()
 *
 * @method \App\Src\Controller\SettingController emailEditAction()
 * @method \App\Src\Controller\SettingController loginEditAction()
 * @method \App\Src\Controller\SettingController passwordEditAction()
 *
 * @method \App\Src\Controller\PhotoController newAction()
 * @method \App\Src\Controller\PhotoController userGalleryAction()
 */
class Controller implements FieldsConst
{
    const REQUEST_METHOD = 'REQUEST_METHOD';
    const REQUEST_URI = 'REQUEST_URI';
    const HTTP_HOST = 'HTTP_HOST';

    const REDIRECT_CODE = 303;

    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';

    const SUCCESS = 'success';
    const ERROR = 'error';

    protected $routes = [];

    protected $result = [];

    /** @var View */
    protected $view;

    protected $model;

    protected $query;

    protected $method;

    protected $auth;

    /**
     * Controller constructor
     *
     * @param array $routes
     * @param string|null $query
     * @param View $view
     */
    public function __construct(View $view, array $routes = [], ?string $query = '')
    {
        $this->routes = $routes;
        $this->view = $view;
        parse_str($query, $this->query);
        $this->method = $_SERVER[self::REQUEST_METHOD];
        $this->auth = new Logger();
    }

    /**
     * @param string $url
     */
    protected function redirect(string $url)
    {
        header('Location: http://' . $_SERVER[self::HTTP_HOST] . $url, true, self::REDIRECT_CODE);
        die();
    }

    protected function userIsLogin()
    {
        try {
            $this->auth->checkUserLogin();
        } catch (\Exception $e) {
            $this->forbidden();
        }
    }

    protected function forbidden()
    {
        header("HTTP/1.1 403 Forbidden");
        $this->redirect('/auth/login');
    }

}
