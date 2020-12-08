<?php

namespace App\Src\Model\Data\TableDataGateway;

use App\Src\Model\Data\Row\CommentRow;
use App\Src\Model\Data\Row\Row;

class CommentGateway extends TableDataGateway
{
    const
        ID         = 'id',
        USER_ID    = 'user_id',
        IMAGE_ID   = 'image_id',
        TEXT       = 'text',
        CREATED_AT = 'created_at'
    ;

    public static function create()
    {
        return new self();
    }

    protected function insert(Row $object)
    {
        /** @var CommentRow $object */
        $values = [
            $object->getImageId(),
            $object->getUserId(),
            $object->getText(),
        ];

        $stmt = $this->pdo->prepare(
            "INSERT INTO comments (image_id, user_id, text) VALUES (?, ?, ?)"
        );

        $stmt->execute($values);
        $object->setId((int)$this->pdo->lastInsertId());
    }

    public function delete(Row $object)
    {
        /** @var CommentRow $object */
        $value = [
            $object->getId()
        ];
        $stmt = $this->pdo->prepare(
            "DELETE FROM comments WHERE id=?"
        );
        $stmt->execute($value);
    }

    protected function update(Row $object)
    {
        /** @var CommentRow $object */
        $values = [
            $object->getImageId(),
            $object->getUserId(),
            $object->getText(),
            $object->getId()
        ];

        $stmt = $this->pdo->prepare(
            "UPDATE comments SET image_id=?, user_id=?, text=? WHERE id=?"
        );
        $stmt->execute($values);
    }

    protected function select(Row $object): \PDOStatement
    {
        return $this->pdo->prepare(
            "SELECT * FROM comments WHERE id=?"
        );
    }

    protected function selectAll(Row $object): \PDOStatement
    {
        return $this->pdo->prepare(
            "SELECT * FROM comments WHERE id=?"
        );
    }

    public function getByImageId(Row $object): ?array
    {
        /** @var CommentRow $object */
        $values = [
            $object->getImageId()
        ];
        $stmt = $this->pdo->prepare(
            "SELECT u.login, u.id as user_id, comments.id, comments.created_at, comments.text FROM comments LEFT JOIN user u on u.id = comments.user_id WHERE image_id=?"
        );
        $stmt->execute($values);

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if (count($rows) === 0) {
            return null;
        }

        return $rows;
    }

    public function getCommentByUserId(Row $object): ?Row
    {
        /** @var CommentRow $object */
        $values = [
            $object->getUserId(),
            $object->getImageId(),
        ];

        $stmt = $this->pdo->prepare(
            "SELECT * FROM comments WHERE user_id=? AND image_id=?"
        );
        $stmt->execute($values);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row === false || count($row) === 0) {
            return null;
        }
        return $this->createObject($row);
    }

    protected function createObject(array $row): Row
    {
        return (new CommentRow())
            ->setId($row[self::ID])
            ->setImageId($row[self::IMAGE_ID])
            ->setUserId($row[self::USER_ID])
            ->setText($row[self::TEXT])
            ->setCreatedAt($row[self::CREATED_AT]);
    }
}
