<?php

namespace App\Src\Controller;

use App\Src\Core\Controller;
use App\Src\Core\View;
use App\Src\Model\DTO\Photo\LikeDto;
use App\Src\Model\Module\Like;

class LikeController extends Controller
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
        $this->model = new Like();
    }

    public function likeAction(): void
    {
        if ($this->method === self::METHOD_POST) {
            $this->userIsLogin();
            $likeDto = (new LikeDto())
                ->setPhotoId($_POST[self::FIELD_PHOTO_ID])
                ->setUserId($_POST[self::FIELD_USER_ID]);
            $this->model->setLikes($likeDto);
        }
        elseif ($this->method === self::METHOD_GET) {
            $likeDto = (new LikeDto())
                ->setPhotoId($_GET[self::FIELD_PHOTO_ID]);
           [$userIsLike, $total] =  $this->model->getLikes($likeDto);
           echo json_encode(['total' => $total, 'user_is_like' => $userIsLike]);
        }
    }
}