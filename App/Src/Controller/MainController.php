<?php

namespace App\Src\Controller;

use App\Src\Core\Controller;
use App\Src\Model\DTO\Photo\GalleryDto;
use App\Src\Model\Module\Photo;

class MainController extends Controller
{
    const COUNT_PAGES = 'count_pages';
    const PAGE = 'page';
    const GALLERY = 'gallery';

    public function __construct($view, array $routes = [], ?string $query = '')
    {
        parent::__construct($view, $routes, $query);
        $this->model = new Photo();
    }


    public function mainAction(): void
    {
        if (isset($this->query[self::FIELD_PAGE])
            && is_numeric($this->query[self::FIELD_PAGE])
            && $this->query[self::FIELD_PAGE] > 0) {

            $page = $this->query[self::FIELD_PAGE];
        } else {
            $page = 1;
        }

        $galleryDto = (new GalleryDto())
            ->setPage($page);
        [$gallery, $total] = $this->model->getGallery($galleryDto);
        $this->result = [self::GALLERY => $gallery, self::COUNT_PAGES => $total, self::PAGE => $page];
        if ($page > $total && $page !== 1) {
            $this->view->error('/error/404.phtml', 404);
        }
        $this->view->renderer('/index.phtml', $this->result);
    }
}
