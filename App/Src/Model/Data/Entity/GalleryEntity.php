<?php

namespace App\Src\Model\Data\Entity;

class GalleryEntity extends Entity
{
    const
        ID         = 'id',
        LOGIN      = 'login',
        TITLE      = 'title',
        PHOTO      = 'photo',
        CREATED_AT = 'created_at'
    ;

    protected $title;

    protected $photo;

    protected $login;

    protected $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): GalleryEntity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return GalleryEntity
     */
    public function setTitle(string $title): GalleryEntity
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
     * @return GalleryEntity
     */
    public function setPhoto(string $photo): GalleryEntity
    {
        $this->photo = $photo;
        return $this;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     * @return GalleryEntity
     */
    public function setLogin(string $login): GalleryEntity
    {
        $this->login = $login;
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
     * @return GalleryEntity
     */
    public function setCreatedAt(string $createdAt): GalleryEntity
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @param array $row
     * @return GalleryEntity
     */
    public function createEntity(array $row): GalleryEntity
    {
        return (new self())
            ->setId($row[self::ID])
            ->setTitle($row[self::TITLE])
            ->setPhoto($row[self::PHOTO])
            ->setCreatedAt($row[self::CREATED_AT])
            ->setLogin($row[self::LOGIN]);
    }
}
