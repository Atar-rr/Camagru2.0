<?php

namespace App\Src\Model\DTO\Photo;

class LikeDto
{
    protected $photoId;

    protected $userId;

    /**
     * @return int
     */
    public function getPhotoId(): int
    {
        return $this->photoId;
    }

    /**
     * @param int $photoId
     * @return LikeDto
     */
    public function setPhotoId(int $photoId): LikeDto
    {
        $this->photoId = $photoId;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return LikeDto
     */
    public function setUserId(int $userId): LikeDto
    {
        $this->userId = $userId;
        return $this;
    }
}
