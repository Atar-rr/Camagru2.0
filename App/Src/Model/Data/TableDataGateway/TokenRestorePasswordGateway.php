<?php


namespace App\Src\Model\Data\TableDataGateway;


use App\Src\Model\Data\Row\Row;
use App\Src\Model\Data\Row\TokenRestorePasswordRow;

class TokenRestorePasswordGateway extends TableDataGateway
{
    const
        ID = 'id',
        USER_ID = 'user_id',
        TOKEN = 'token',
        CREATED_DATE = 'created_date';

    public static function create()
    {
        return new self();
    }

    protected function insert(Row $object)
    {
        $values = [$object->getUserId(), $object->getToken()];

        $stmt = $this->pdo->prepare(
            "INSERT INTO token_restore_password (user_id, token) VALUES (?, ?)"
        );

        $stmt->execute($values);
        $object->setId((int)$this->pdo->lastInsertId());
    }

    protected function update(Row $object)
    {
        $values = [
            $object->getId(),
            $object->getUserId(),
            $object->getToken()
        ];

        $stmt = $this->pdo->prepare(
            "UPDATE token_restore_password SET user_id=?, token=? WHERE id=?"
        );
        $stmt->execute($values);
    }

    protected function select(Row $object): \PDOStatement
    {
        return $this->pdo->prepare(
            "SELECT * FROM token_restore_password WHERE id=? LIMIT 1"
        );
    }

    public function selectByToken(Row $object)
    {
        $values = [
            $object->getToken(),
        ];

        $stmt = $this->pdo->prepare(
            "SELECT * FROM token_restore_password WHERE token=? LIMIT 1"
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
            "SELECT * FROM token_restore_password WHERE id=?"
        );
    }

    public function delete(Row $object)
    {
        $value = [
            $object->getId()
        ];
        $stmt = $this->pdo->prepare(
            "DELETE FROM token_restore_password WHERE id=?"
        );
        $stmt->execute($value);
    }

    protected function createObject(array $row): Row
    {
        return
            (new TokenRestorePasswordRow())
                ->setId($row[self::ID])
                ->setUserId($row[self::USER_ID])
                ->setToken($row[self::TOKEN])
                ->setCreatedDate($row[self::CREATED_DATE]);
    }
}