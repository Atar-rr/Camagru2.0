<?php

namespace App\Src\Model\DTO\Photo;

class UserPhotoDto
{
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return UserPhotoDto
     */
    public function setId(int $id): UserPhotoDto
    {
        $this->id = $id;
        return $this;
    }
}
