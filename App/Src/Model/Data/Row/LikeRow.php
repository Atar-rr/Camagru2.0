<?php

namespace App\Src\Model\Data\Row;

class LikeRow extends Row
{
    protected $imageId;

    protected $userId;

    public static function create()
    {
        return new self();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): LikeRow
    {
       $this->id = $id;
       return $this;
    }

    /**
     * @return int
     */
    public function getImageId(): int
    {
        return $this->imageId;
    }

    /**
     * @param int $imageId
     * @return LikeRow
     */
    public function setImageId(int $imageId): LikeRow
    {
        $this->imageId = $imageId;
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
     * @return LikeRow
     */
    public function setUserId(int $userId): LikeRow
    {
        $this->userId = $userId;
        return $this;
    }
}
