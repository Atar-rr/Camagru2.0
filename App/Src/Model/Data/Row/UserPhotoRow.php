<?php

namespace App\Src\Model\Data\Row;

class UserPhotoRow extends Row
{
    protected $userId;

    protected $name;

    protected $title;

    protected $photo;

    protected $createdAt;

    /**
     * @return UserPhotoRow
     */
    public static function create(): UserPhotoRow
    {
        return new self();
    }

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
    public function setId(int $id): UserPhotoRow
    {
        $this->id = $id;
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
     * @return UserPhotoRow
     */
    public function setUserId(int $userId): UserPhotoRow
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return UserPhotoRow
     */
    public function setName(string $name): UserPhotoRow
    {
        $this->name= $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return UserPhotoRow
     */
    public function setTitle(?string $title): UserPhotoRow
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoto(): string
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     * @return UserPhotoRow
     */
    public function setPhoto(string $photo): UserPhotoRow
    {
        $this->photo = $photo;
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
     * @return UserPhotoRow
     */
    public function setCreatedAt(string $createdAt): UserPhotoRow
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
