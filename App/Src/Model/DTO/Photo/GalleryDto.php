<?php

namespace App\Src\Model\DTO\Photo;

class GalleryDto
{
    protected $page;

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     * @return GalleryDto
     */
    public function setPage(int $page): GalleryDto
    {
        $this->page = $page;
        return $this;
    }
}
