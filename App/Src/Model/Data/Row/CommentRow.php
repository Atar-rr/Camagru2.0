<?php

namespace App\Src\Model\Data\Row;

class CommentRow extends Row
{
    protected $imageId;

    protected $userId;

    protected $text;

    protected $createdAt;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): CommentRow
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
     * @return CommentRow
     */
    public function setImageId(int $imageId): CommentRow
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
     * @return CommentRow
     */
    public function setUserId(int $userId): CommentRow
    {
        $this->userId = $userId;
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
     * @return CommentRow
     */
    public function setText(string $text): CommentRow
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     * @return CommentRow
     */
    public function setCreatedAt(string $createdAt): CommentRow
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public static function create()
    {
        return new self();
    }
}
