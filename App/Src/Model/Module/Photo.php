<?php

namespace App\Src\Model\Module;

use App\Src\Exception\NotFoundException;
use App\Src\Exception\UserUnauthorizedException;
use App\Src\Model\Data\Criteria\GalleryCriteria;
use App\Src\Model\Data\Entity\GalleryEntity;
use App\Src\Model\Data\Row\UserPhotoRow;
use App\Src\Model\Data\TableDataGateway\UserPhotoGateway;
use App\Src\Model\DTO\Photo\GalleryDto;
use App\Src\Model\DTO\Photo\NewDto;
use App\Src\Model\DTO\Photo\UserPhotoDto;
use App\Src\Model\Service\Auth;
use App\Src\Model\Service\Tokenizer;
use App\Src\Model\Type\PhotoType;

class Photo
{
    const CHUNK = 6;

    protected $userPhotoRow;

    protected $userPhotoGateway;

    protected $photoType;

    public function __construct()
    {
        $this->userPhotoRow = UserPhotoRow::create();
        $this->userPhotoGateway = UserPhotoGateway::create();
        $this->photoType = PhotoType::create();
    }

    /**
     * @param NewDto $newDto
     * @throws \App\Src\Exception\ValidateException
     */
    public function newPhoto(NewDto $newDto): void
    {
        $photo = $newDto->getPhoto();
        $this->photoType->validate($photo);

        if ($newDto->getMasks() !== '') {
            $photo = $this->mergePhotos($photo, $newDto->getMasks());
        }
        $name = Tokenizer::generate(5) . '.' . $this->photoType->getPhotoType();
        $userId = Auth::getUserIdFromSession();
        $this->userPhotoRow
            ->setName($name)
            ->setTitle($newDto->getTitle())
            ->setUserId($userId)
            ->setPhoto($photo);
        $this->userPhotoGateway->save($this->userPhotoRow);
    }

    public function getGallery(GalleryDto $galleryDto): array
    {
        $result = [];

        $offset = ($galleryDto->getPage() - 1) * self::CHUNK;
        $countRows = ceil($this->userPhotoGateway->getCountRows() / self::CHUNK);

        $galleryCriteria = (new GalleryCriteria())
            ->setChunk(self::CHUNK)
            ->setOffset($offset)
        ;

        $gallery = $this->userPhotoGateway->getGalleryByCriteria($galleryCriteria);

        /** @var GalleryEntity $value */
        foreach ($gallery as $value) {
            $result[] = [
                'id' => $value->getId(),
                'photo' => $value->getPhoto(),
                'login' => $value->getLogin(),
                'title' => $value->getTitle(),
                'created_at' => $value->getCreatedAt(),
            ];
        }

        return [$result, (int)$countRows];
    }

    /**
     * @return string
     */
    public function getUserGallery(): string
    {
        $result = [];

        $userId = Auth::getUserIdFromSession();
        $this->userPhotoRow->setUserId($userId);
        $userPhotos = $this->userPhotoGateway->getByUserId($this->userPhotoRow);

        /** @var UserPhotoRow $photo */
        foreach ($userPhotos as $photo) {
            $result[] = [
                'id' => $photo->getId(),
                'photo' => $photo->getPhoto(),
            ];
        }

        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function getUserPhoto(UserPhotoDto $photoDto): array
    {
        $result = [];

        $this->userPhotoRow->setId($photoDto->getId());
        $row = $this->userPhotoGateway->getRow($this->userPhotoRow);

        if ($row === null) {
            return $result;
        }
        $userId = Auth::getUserIdFromSession();

        /** @var UserPhotoRow $row */
        $result = [
            'id' => $row->getId(),
            'user_id' => $row->getUserId(),
            'title' => $row->getTitle(),
            'created_at' => $row->getCreatedAt(),
            'photo' => $row->getPhoto(),
            'is_owner' => $userId === $row->getUserId()
        ];

        return $result;
    }

    /**
     * @param UserPhotoDto $photoDto
     * @throws NotFoundException
     * @throws UserUnauthorizedException
     */
    public function deleteUserPhoto(UserPhotoDto $photoDto): void
    {
        $this->userPhotoRow->setId($photoDto->getId());

        /** @var UserPhotoRow  $row */
        $row = $this->userPhotoGateway->getRow($this->userPhotoRow);

        if ($row === null) {
            throw new NotFoundException('Изображение не найдено');
        }

        $userId = Auth::getUserIdFromSession();
        if ($userId !== $row->getUserId()) {
            throw new UserUnauthorizedException('Изображение вам не принадлежит');
        }

        $this->userPhotoGateway->delete($row);
    }

    private function mergePhotos(string $photo, string $mask): string
    {
        $image = $photo;

        $image = str_replace('data:image/png;base64,', '', $image);
        $filter = str_replace('data:image/png;base64,', '', $mask);

        $image = base64_decode($image);
        $filter = base64_decode($filter);

        $image = imagecreatefromstring($image);
        $filter = imagecreatefromstring($filter);

        imagealphablending($filter, false);
        imagesavealpha($filter, true);

        $wSrc = imagesx($image);
        $hSrc = imagesy($image);

        imagecopyresampled($image, $filter, 0, 0, 0, 0, $wSrc, $hSrc, $wSrc, $hSrc);
        imagealphablending($image, false);
        imagesavealpha($image, true);

        $imageName = __DIR__ .  "/tmp/tmp_" . Auth::getUserIdFromSession() . ".png";
        imagepng($image, $imageName);
        $data = file_get_contents($imageName);
        unlink($imageName);

        return "data:image/png;base64," . base64_encode($data);
    }
}
