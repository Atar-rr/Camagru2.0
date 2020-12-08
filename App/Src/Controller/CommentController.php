<?php

namespace App\Src\Controller;

use App\Src\Core\Controller;
use App\Src\Core\View;
use App\Src\Exception\UserUnauthorizedException;
use App\Src\Model\DTO\Photo\CommentDto;
use App\Src\Model\Module\Comment;

class CommentController extends Controller
{
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
        $this->model = new Comment();
    }

    public function commentAction()
    {
        if ($this->method === self::METHOD_POST) {
            $this->userIsLogin();
            $commentDto = (new CommentDto())
                ->setImageId($_POST[self::FIELD_PHOTO_ID])
                ->setUserId($_POST[self::FIELD_USER_ID])
                ->setText($_POST[self::FIELD_TEXT])
            ;
            $this->model->addComment($commentDto);
        } elseif ($this->method === self::METHOD_GET) {
            $commentDto = (new CommentDto())
                ->setImageId($_GET[self::FIELD_PHOTO_ID]);
            $rows =  $this->model->getComments($commentDto);
            echo json_encode(['comments' => $rows]);
        }
    }

    public function deleteAction()
    {
        $this->userIsLogin();
        $commentDto = (new CommentDto())
            ->setId($_POST[self::FIELD_ID]);
        try {
            $this->model->deleteComment($commentDto);
        } catch (\Exception $e) {
            if ($e instanceof UserUnauthorizedException) {
                $this->redirect('/auth/login');
            }
            $this->view->error('/error/404.phtml', 404);
        }
    }
}
