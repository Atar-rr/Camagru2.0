<?php

namespace App\Src\Model\Data\TableDataGateway;

use App\Src\Model\Data\Row\Row;
use App\Src\Model\Data\Row\UserSessionRow;

class UserSessionGateway extends TableDataGateway
{
    public const
        ID = 'id',
        USER_ID = 'user_id',
        TOKEN = 'token',
        CREATED_DATE = 'created_date';

    public static function create(): UserSessionGateway
    {
        return new self();
    }

    /**
     * @param Row $object
     */
    protected function insert(Row $object): void
    {
        /** @var UserSessionRow  $object */
        $values = [$object->getUserId(), $object->getToken()];

        $stmt = $this->pdo->prepare(
            "INSERT INTO user_session (user_id, token) VALUES (?, ?)"
        );

        $stmt->execute($values);
        $object->setId((int)$this->pdo->lastInsertId());
    }

    protected function update(Row $object): void
    {
        /** @var UserSessionRow  $object */
        $values = [
            $object->getId(),
            $object->getUserId(),
            $object->getToken()
        ];

        $stmt = $this->pdo->prepare(
            "UPDATE user_session SET user_id=?, token=? WHERE id=?"
        );
        $stmt->execute($values);
    }

    protected function select(Row $object): \PDOStatement
    {
        return $this->pdo->prepare(
            "SELECT * FROM user_session WHERE id=?"
        );
    }

    public function selectByToken(Row $object): void
    {
        /** @var UserSessionRow  $object */
        $values = [
            $object->getToken(),
        ];

        $stmt = $this->pdo->prepare(
            "SELECT * FROM user_session WHERE token=? LIMIT 1"
        );

        $stmt->execute($values);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (is_array($row)) {
            $object
                ->setId($row[self::ID])
                ->setUserId($row[self::USER_ID])
                ->setCreatedDate($row[self::CREATED_DATE]);
        }
    }

    protected function selectAll(Row $object): \PDOStatement
    {
        return $this->pdo->prepare(
            "SELECT * FROM user_session WHERE id=?"
        );
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
            "DELETE FROM user_session WHERE id=?"
        );
        $stmt->execute($value);
    }

    /**
     * @param Row $object
     */
    public function deleteByToken(Row $object): void
    {
        /** @var UserSessionRow  $object */
        $value = [
            $object->getToken()
        ];
        $stmt = $this->pdo->prepare(
            "DELETE FROM user_session WHERE token=?"
        );
        $stmt->execute($value);
    }

    /**
     * @param Row $object
     */
    public function deleteByUserId(Row $object): void
    {
        /** @var UserSessionRow  $object */
        $value = [
            $object->getUserId()
        ];
        $stmt = $this->pdo->prepare(
            "DELETE FROM user_session WHERE user_id=?"
        );
        $stmt->execute($value);
    }

    /**
     * @param array $row
     * @return Row
     */
    protected function createObject(array $row): Row
    {
        return
            (new UserSessionRow())
                ->setId($row[self::ID])
                ->setUserId($row[self::USER_ID])
                ->setToken($row[self::TOKEN])
                ->setCreatedDate($row[self::CREATED_DATE]);
    }
}