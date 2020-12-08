<?php

namespace App\Src\Model\Module;

use App\Src\Model\Data\Row\LikeRow;
use App\Src\Model\Data\TableDataGateway\LikeGateway;
use App\Src\Model\DTO\Photo\LikeDto;
use App\Src\Model\Service\Logger;

class Like
{
    protected $likeGateway;

    protected $likeRow;

    public function __construct()
    {
        $this->likeRow = LikeRow::create();
        $this->likeGateway = LikeGateway::create();
    }

    public function getLikes(LikeDto $likeDto): array
    {
        $userIsLike = false;

        $this->likeRow->setImageId($likeDto->getPhotoId());
        $total = $this->likeGateway->getCountByImageId($this->likeRow);
        $userId = Logger::getUserIdFromSession();
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

    public function setLikes(LikeDto $likeDto)
    {
        $this->likeRow
            ->setUserId($likeDto->getUserId())
            ->setImageId($likeDto->getPhotoId())
        ;

        $userId = Logger::getUserIdFromSession();
        $this->likeRow->setImageId($likeDto->getPhotoId());
        $this->likeRow->setUserId($userId);
        $row = $this->likeGateway->getLikeByUserId($this->likeRow);

        if ($row !== null) {
            $this->likeGateway->delete($row);
        } else {
            $this->likeGateway->save($this->likeRow);
        }
    }
}
