<?php

namespace App\Src\Model\Data\TableDataGateway;

use App\Src\Model\Data\Row\Row;
use App\Src\Model\Data\Row\TokenActivateUserRow;

class TokenActivateUserGateway extends TableDataGateway
{
    public const
        ID = 'id',
        USER_ID = 'user_id',
        TOKEN = 'token',
        CREATED_DATE = 'created_date';

    /**
     * @return TokenActivateUserGateway
     */
    public static function create(): TokenActivateUserGateway
    {
        return new self();
    }

    /**
     * @param Row $object
     */
    protected function insert(Row $object): void
    {
        /** @var TokenActivateUserRow $object */
        $values = [
            $object->getUserId(),
            $object->getToken()
        ];

        $stmt = $this->pdo->prepare(
            "INSERT INTO token_activate_user (user_id, token) VALUES (?, ?)"
        );

        $stmt->execute($values);
        $object->setId((int)$this->pdo->lastInsertId());
    }

    /**
     * @param Row $object
     */
    protected function update(Row $object): void
    {
        /** @var TokenActivateUserRow $object */
        $values = [
            $object->getId(),
            $object->getUserId(),
            $object->getToken()
        ];

        $stmt = $this->pdo->prepare(
            "UPDATE token_activate_user SET user_id=?, token=? WHERE id=?"
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
            "SELECT * FROM token_activate_user WHERE id=? LIMIT 1"
        );
    }

    /**
     * @param Row $object
     */
    public function selectByToken(Row $object): void
    {
        /** @var TokenActivateUserRow $object */
        $values = [
            $object->getToken(),
        ];

        $stmt = $this->pdo->prepare(
            "SELECT * FROM token_activate_user WHERE token=? LIMIT 1"
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

    /**
     * @param Row $object
     * @return \PDOStatement
     */
    protected function selectAll(Row $object): \PDOStatement
    {
        return $this->pdo->prepare(
            "SELECT * FROM token_activate_user WHERE id=?"
        );
    }

    /**
     * @param Row $object
     */
    public function delete(Row $object): void
    {
        /** @var TokenActivateUserRow $object */
        $value = [
            $object->getId()
        ];
        $stmt = $this->pdo->prepare(
            "DELETE FROM token_activate_user WHERE id=?"
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
            (new TokenActivateUserRow())
                ->setId($row[self::ID])
                ->setUserId($row[self::USER_ID])
                ->setToken($row[self::TOKEN])
                ->setCreatedDate($row[self::CREATED_DATE]);
    }
}
