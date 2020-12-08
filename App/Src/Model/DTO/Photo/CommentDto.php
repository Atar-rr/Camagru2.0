<?php

namespace App\Src\Model\DTO\Photo;

class CommentDto
{
    protected $id;

    protected $text;

    protected $userId;

    protected $imageId;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return CommentDto
     */
    public function setId(int $id): CommentDto
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return CommentDto
     */
    public function setText(string $text): CommentDto
    {
        $this->text = $text;
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
     * @return CommentDto
     */
    public function setUserId(int $userId): CommentDto
    {
        $this->userId = $userId;
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
     * @return CommentDto
     */
    public function setImageId(int $imageId): CommentDto
    {
        $this->imageId = $imageId;
        return $this;
    }
}
