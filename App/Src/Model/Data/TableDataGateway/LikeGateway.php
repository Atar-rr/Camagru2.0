<?php

namespace App\Src\Model\Data\TableDataGateway;

use App\Src\Model\Data\Row\LikeRow;
use App\Src\Model\Data\Row\Row;

class LikeGateway extends TableDataGateway
{
    const
        ID         = 'id',
        USER_ID    = 'user_id',
        IMAGE_ID   = 'image_id'
       ;

    public static function create(): LikeGateway
    {
        return new self();
    }

    protected function insert(Row $object)
    {
        /** @var LikeRow $object */
        $values = [
            $object->getUserId(),
            $object->getImageId()
        ];

        $stmt = $this->pdo->prepare(
            "INSERT INTO `like` (user_id, image_id) VALUES (?, ?)"
        );

        $stmt->execute($values);
        $object->setId((int)$this->pdo->lastInsertId());
    }

    public function delete(Row $object)
    {
        $value = [
            $object->getId()
        ];
        $stmt = $this->pdo->prepare(
            "DELETE FROM `like` WHERE id=?"
        );
        $stmt->execute($value);
    }

    protected function update(Row $object)
    {
        /** @var LikeRow $object */
        $values = [
            $object->getUserId(),
            $object->getImageId(),
            $object->getId()
        ];

        $stmt = $this->pdo->prepare(
            "UPDATE `like` SET user_id=?, image_id=? WHERE id=?"
        );
        $stmt->execute($values);
    }

    protected function select(Row $object): \PDOStatement
    {
        return $this->pdo->prepare(
            "SELECT * FROM `like` WHERE id=?"
        );
    }

    public function getCountByImageId(Row $object): int
    {
        /** @var LikeRow $object */
        $values = [
            $object->getImageId(),
        ];
        $stmt = $this->pdo->prepare(
            "SELECT count(id) FROM `like` WHERE image_id=? "
        );
        $stmt->execute($values);
        $tmp = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $tmp['count(id)'];
    }

    public function getLikeByUserId(Row $object): ?Row
    {
        /** @var LikeRow $object */
        $values = [
            $object->getUserId(),
            $object->getImageId(),
        ];
        $stmt = $this->pdo->prepare(
            "SELECT * FROM `like` WHERE user_id=? AND image_id=?"
        );
        $stmt->execute($values);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($row === false  || count($row) === 0) {
            return null;
        }
        return $this->createObject($row);
    }

    /**
     * @inheritDoc
     */
    protected function selectAll(Row $object): \PDOStatement
    {
        return $this->pdo->prepare(
            "SELECT * FROM `like` WHERE id=?"
        );
    }

    /**
     * @inheritDoc
     */
    protected function createObject(array $row): Row
    {
        return (new LikeRow())
            ->setId($row[self::ID])
            ->setUserId($row[self::USER_ID])
            ->setImageId($row[self::IMAGE_ID])
            ;
    }
}
