<?php

namespace App\Src\Model\Module;

use App\Src\Exception\NotFoundException;
use App\Src\Exception\UserUnauthorizedException;
use App\Src\Model\Data\Row\CommentRow;
use App\Src\Model\Data\Row\UserPhotoRow;
use App\Src\Model\Data\Row\UserRow;
use App\Src\Model\Data\TableDataGateway\CommentGateway;
use App\Src\Model\Data\TableDataGateway\UserGateway;
use App\Src\Model\Data\TableDataGateway\UserPhotoGateway;
use App\Src\Model\DTO\Photo\CommentDto;
use App\Src\Model\Service\Logger;
use App\Src\Model\Service\Mailer;

class Comment
{
    const USER_ID = 'user_id';
    const IS_USER_COMMENT = 'is_user_comment';

    protected $commentRow;

    protected $commentGateway;

    protected $photoRow;

    protected $photoGateway;

    protected $userGateway;

    protected $userRow;

    public function __construct()
    {
        $this->commentGateway = CommentGateway::create();
        $this->commentRow = CommentRow::create();
        $this->photoGateway = UserPhotoGateway::create();
        $this->photoRow = UserPhotoRow::create();
        $this->userGateway = UserGateway::create();
        $this->userRow = UserRow::create();
    }

    /**
     * @param CommentDto $commentDto
     * @throws NotFoundException
     * @throws UserUnauthorizedException
     */
    public function deleteComment(CommentDto $commentDto)
    {
        $this->commentRow
            ->setId($commentDto->getId());

        /** @var CommentRow $row */
        $row = $this->commentGateway->getRow($this->commentRow);

        if ($row === null) {
            throw new NotFoundException('Комментарий не найден');
        }

        $userId = Logger::getUserIdFromSession();
        if ($userId !== $row->getUserId()) {
            throw new UserUnauthorizedException('Комментарий вам не принадлежит');
        }

        $this->commentGateway->delete($row);

    }

    public function addComment(CommentDto $commentDto)
    {
        $this->commentRow
            ->setImageId($commentDto->getImageId())
            ->setUserId(Logger::getUserIdFromSession())
            ->setText($commentDto->getText());
        $this->commentGateway->save($this->commentRow);

        $this->photoRow->setId($commentDto->getImageId());

        /** @var UserPhotoRow $row */
        $row = $this->photoGateway->getRow($this->photoRow);

        $this->userRow->setId($row->getUserId());

        /** @var UserRow $userRow */
        $userRow = $this->userGateway->getRow($this->userRow);
        if ($userRow->getNotify() === true) {
            $this->sendNotify($userRow->getEmail(), $commentDto->getImageId());
        }
    }

    public function getComments(CommentDto $commentDto)
    {
        $this->commentRow
            ->setImageId($commentDto->getImageId());
        $rows = $this->commentGateway->getByImageId($this->commentRow);
        if ($rows === null) {
            return [];
        }
        $userId = Logger::getUserIdFromSession();

        foreach ($rows as &$row) {
            if ($row[self::USER_ID] === $userId) {
                $row[self::IS_USER_COMMENT] = true;
                continue;
            }
            $row[self::IS_USER_COMMENT] = false;
        }

        return $rows;
    }

    protected function sendNotify($email, $photoID)
    {
        $title = 'Новый комментарий';
        $body = "У вас новый комментарий под фото http://localhost:8080/photo/{$photoID}";

        Mailer::sendMail($email, $title, $body);
    }
}
