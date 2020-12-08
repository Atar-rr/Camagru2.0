<?php

namespace App\Src\Model\Type;

use App\Src\Exception\ValidateException;

class PhotoType extends BaseType
{
    const MIMI = 'mime';

    const WHITE_LIST_TYPE = [
        'image/png',
        'image/jpg',
        'image/jpeg',
    ];

    protected $photoType;

    /**
     * @param string $photo
     * @throws ValidateException
     */
    public function validate(string $photo)
    {
        if ($photo === '') {
            throw new ValidateException('Ошибка загрузки фото');
        }

        $imageInfo = getimagesize($photo);
        if (!in_array($imageInfo[self::MIMI], self::WHITE_LIST_TYPE)) {
            throw new ValidateException('Загружать можно только следующие типы данных: ' . implode(' ', self::WHITE_LIST_TYPE));
        }
        $this->photoType = explode('/', $imageInfo[self::MIMI])[1];
    }

    public function getPhotoType()
    {
        return $this->photoType;
    }

    public static function create(): PhotoType
    {
        return new self();
    }
}