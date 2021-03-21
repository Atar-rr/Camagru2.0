<?php

namespace App\Src\Model\Module;

use App\Src\Model\Data\Row\LikeRow;
use App\Src\Model\Data\Row\UserPhotoRow;
use App\Src\Model\Data\Row\UserRow;
use App\Src\Model\Data\TableDataGateway\LikeGateway;
use App\Src\Model\Data\TableDataGateway\UserGateway;
use App\Src\Model\Data\TableDataGateway\UserPhotoGateway;
use App\Src\Model\DTO\Photo\LikeDto;
use App\Src\Model\Service\Auth;
use App\Src\Model\Service\Mailer;

class Like
{
    protected $likeGateway;

    protected $likeRow;

    protected $userRow;

    protected $userGateway;

    protected $photoRow;

    protected $photoGateway;

    public function __construct()
    {
        $this->likeRow = LikeRow::create();
        $this->likeGateway = LikeGateway::create();
        $this->userRow = UserRow::create();
        $this->userGateway = UserGateway::create();
        $this->photoGateway = UserPhotoGateway::create();
        $this->photoRow = UserPhotoRow::create();
    }

    public function getLikes(LikeDto $likeDto): array
    {
        $userIsLike = false;

        $this->likeRow->setImageId($likeDto->getPhotoId());
        $total = $this->likeGateway->getCountByImageId($this->likeRow);
        $userId = Auth::getUserIdFromSession();
        if ($userId === null) {
            return [$userIsLike, $total];
        }

        $this->likeRow->setUserId($userId);
        $row = $this->likeGateway->getLikeByUserId($this->likeRow);
        if ($row !== null) {
            $userIsLike = true;
        }

        return [$userIsLike, $total];
    }

    /**
     * @param LikeDto $likeDto
     */
    public function setLikes(LikeDto $likeDto)
    {
        $userId = Auth::getUserIdFromSession();
        $imageId = $likeDto->getPhotoId();

        $this->likeRow->setImageId($imageId);
        $this->likeRow->setUserId($userId);
        $row = $this->likeGateway->getLikeByUserId($this->likeRow);

        if ($row !== null) {
            $this->likeGateway->delete($row);
        } else {
            $this->photoRow->setId($imageId);

            /** @var UserPhotoRow $imageRow */
            $imageRow = $this->photoGateway->getRow($this->photoRow);
            $this->userRow->setId($imageRow->getUserId());

            /** @var UserRow $userRow */
            $userRow = $this->userGateway->getRow($this->userRow);
            if ($userRow->getNotify() === true) {
                $this->sendNotify($userRow->getEmail(), $imageId);
            }

            $this->likeGateway->save($this->likeRow);
        }
    }

    protected function sendNotify($email, $photoID)
    {
        $title = 'Лайк';
        $body = "Вам поставили лайк под фото http://localhost:8080/photo/{$photoID}";

        Mailer::sendMail($email, $title, $body);
    }
}
