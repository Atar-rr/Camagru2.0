<?php

namespace App\Src\Controller;

use App\Src\Core\Controller;
use App\Src\Core\View;
use App\Src\Model\DTO\Photo\NewDto;
use App\Src\Model\DTO\Photo\UserPhotoDto;
use App\Src\Model\Module\Photo;
use Cassandra\Exception\UnauthorizedException;

class PhotoController extends Controller
{
    public function __construct(View $view, array $routes = [], ?string $query = '')
    {
        parent::__construct($view, $routes, $query);
        $this->model = new Photo();
    }

    public function newAction(): void
    {
        $this->userIsLogin();

        if ($this->method === self::METHOD_POST) {
            $newDto = (new NewDto())
                ->setPhoto($_POST[self::FIELD_PHOTO] ?? '')
                ->setMasks($_POST[self::FIELD_MASKS] ?? '')
                ->setTitle($_POST[self::FIELD_TITLE] ?? '')
            ;

            try {
                $this->model->newPhoto($newDto);
            } catch (\Exception $e) {
                $this->result = ['error' => $e->getMessage()];
                $this->view->renderer('/photo/new.phtml', $this->result);
            }

        } if ($this->method === self::METHOD_GET) {
            $this->view->renderer('/photo/new.phtml');
        }

    }

    public function userGalleryAction(): void
    {
        $this->userIsLogin();

        echo $this->model->getUserGallery();
    }

    public function showAction()
    {
        $id = explode('/', $_SERVER[self::REQUEST_URI])[2];
        $userPhotoDto =  (new UserPhotoDto())->setId($id);
        $this->result = $this->model->getUserPhoto($userPhotoDto);
        if (count($this->result) === 0) {
            $this->view->error('/error/404.phtml', 404);
        }
        $this->view->renderer('/photo/show.phtml', $this->result);
    }

    public function deleteAction()
    {
        $this->userIsLogin();

        $id = explode('/', $_SERVER[self::REQUEST_URI])[2];
        $userPhotoDto = (new UserPhotoDto())->setId($id);
        try {
            $this->model->deleteUserPhoto($userPhotoDto);
            $this->redirect('/');
        } catch (\Exception $e) {
            if ($e instanceof UnauthorizedException) {
                $this->redirect('/auth/login');
            }
            $this->view->error('/error/404.phtml', 404);
        }
    }
}
