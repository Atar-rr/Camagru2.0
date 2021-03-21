<?php

namespace App\Src\Model\Data\TableDataGateway;

use App\Src\Model\Data\Row\LikeRow;
use App\Src\Model\Data\Row\Row;

class LikeGateway extends TableDataGateway
{
    public const
        ID         = 'id',
        USER_ID    = 'user_id',
        IMAGE_ID   = 'image_id'
       ;

    /**
     * @return LikeGateway
     */
    public static function create(): LikeGateway
    {
        return new self();
    }

    /**
     * @param Row $object
     */
    protected function insert(Row $object): void
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

    /**
     * @param Row $object
     */
    public function delete(Row $object): void
    {
        $value = [
            $object->getId()
        ];
        $stmt = $this->pdo->prepare(
            "DELETE FROM `like` WHERE id=?"
        );
        $stmt->execute($value);
    }

    /**
     * @param Row $object
     */
    protected function update(Row $object): void
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

    /**
     * @param Row $object
     * @return \PDOStatement
     */
    protected function select(Row $object): \PDOStatement
    {
        return $this->pdo->prepare(
            "SELECT * FROM `like` WHERE id=?"
        );
    }

    /**
     * @param Row $object
     * @return int
     */
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

    /**
     * @param Row $object
     * @return Row|null
     */
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
     * @param Row $object
     * @return \PDOStatement
     */
    protected function selectAll(Row $object): \PDOStatement
    {
        return $this->pdo->prepare(
            "SELECT * FROM `like` WHERE id=?"
        );
    }


    /**
     * @param array $row
     * @return Row
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
