<?php

namespace App\Src\Model\Type;

use App\Src\Exception\ValidateException;

class PhotoType extends BaseType
{
    public const MIMI = 'mime';

    public const WHITE_LIST_TYPE = [
        'image/png',
        'image/jpg',
        'image/jpeg',
    ];

    protected $photoType;

    /**
     * @param string $photo
     * @throws ValidateException
     */
    public function validate(string $photo): void
    {
        if ($photo === '') {
            throw new ValidateException('Ошибка загрузки фото');
        }

        $imageInfo = getimagesize($photo);
        if (!in_array($imageInfo[self::MIMI], self::WHITE_LIST_TYPE, true)) {
            throw new ValidateException('Загружать можно только следующие типы данных: ' . implode(' ', self::WHITE_LIST_TYPE));
        }
        $this->photoType = explode('/', $imageInfo[self::MIMI])[1];
    }

    /**
     * @return mixed
     */
    public function getPhotoType()
    {
        return $this->photoType;
    }

    /**
     * @return PhotoType
     */
    public static function create(): PhotoType
    {
        return new self();
    }
}