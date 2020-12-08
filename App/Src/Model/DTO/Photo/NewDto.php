<?php

namespace App\Src\Model\DTO\Photo;

class NewDto
{
    protected $photo;

    protected $title;

    protected $masks;

    /**
     * @return string
     */
    public function getPhoto(): string
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     * @return NewDto
     */
    public function setPhoto(string $photo): NewDto
    {
        $this->photo = $photo;
        return $this;
    }

    /**
     * @return string
     */
    public function getMasks(): string
    {
        return $this->masks;
    }

    /**
     * @param string $masks
     * @return NewDto
     */
    public function setMasks(string $masks): NewDto
    {
        $this->masks = $masks;
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
     * @return NewDto
     */
    public function setTitle(string $title): NewDto
    {
        $this->title = $title;
        return $this;
    }
}
