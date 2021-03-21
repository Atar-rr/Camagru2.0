<?php

namespace App\Src\Model\Data\TableDataGateway;

use App\Src\Model\Data\Row\Row;
use App\Src\Model\Data\Row\UserRow;

class UserGateway extends TableDataGateway
{
    public const
        ID = 'id',
        EMAIL = 'email',
        LOGIN = 'login',
        PASSWORD = 'password',
        NOTIFY = 'notify',
        ACTIVE_STATUS = 'active_status',
        CREATE_DATE = 'create_date',
        UPDATE_DATE = 'update_date';

    /**
     * @return UserGateway
     */
    public static function create(): UserGateway
    {
        return new self();
    }

    /**
     * @param Row $object
     * @return \PDOStatement
     */
    public function select(Row $object): \PDOStatement
    {
        return $this->pdo->prepare(
            "SELECT * FROM user WHERE id=? LIMIT 1"
        );
    }

    /**
     * @param Row $object
     * @return \PDOStatement
     */
    public function selectAll(Row $object): \PDOStatement
    {
        return $this->pdo->prepare(
            "SELECT * FROM user WHERE id=?"
        );
    }

    /**
     * @param Row $object
     */
    public function insert(Row $object): void
    {
        /** @var UserRow $object */
        $values = [
            $object->getEmail(),
            $object->getLogin(),
            $object->getPassword(),
        ];

        $stmt = $this->pdo->prepare(
            "INSERT INTO user (email, login, password) VALUES (?, ?, ?)"
        );

        $stmt->execute($values);
        $object->setId((int)$this->pdo->lastInsertId());
    }

    /**
     * @param Row $object
     */
    public function update(Row $object): void
    {
        /** @var UserRow $object */
        $values = [
            $object->getEmail(),
            $object->getLogin(),
            $object->getPassword(),
            $object->getActiveStatus(),
            $object->getNotify(),
            $object->getId()
        ];

        $stmt = $this->pdo->prepare(
            "UPDATE user SET email=?, login=?, password=?, active_status=?, notify=? WHERE id=?"
        );
        $stmt->execute($values);
    }

    /**
     * @param Row $object
     */
    public function activateUser(Row $object): void
    {
        /** @var UserRow $object */
        $values = [
            $object->getActiveStatus(),
            $object->getId()
        ];
        $stmt = $this->pdo->prepare(
            "UPDATE user SET active_status=? WHERE id=?"
        );

        $stmt->execute($values);
    }

    /**
     * @param Row $object
     */
    public function getByEmail(Row $object): void
    {
        /** @var UserRow $object */
        $values = [
            $object->getEmail(),
        ];

        $stmt = $this->pdo->prepare(
            "SELECT * FROM user WHERE email=?"
        );

        $stmt->execute($values);

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (is_array($row)) {
            $object
                ->setId($row[self::ID])
                ->setLogin($row[self::LOGIN])
                ->setPassword($row[self::PASSWORD])
                ->setNotify($row[self::NOTIFY])
                ->setActiveStatus($row[self::ACTIVE_STATUS])
                ->setCreateDate($row[self::CREATE_DATE])
                ->setUpdateDate($row[self::UPDATE_DATE]);
        }
    }

    /**
     * @param Row $object
     */
    public function getByEmailOrLogin(Row $object): void
    {
        /** @var UserRow $object */
        $values = [
            $object->getLogin(),
            $object->getLogin()
        ];

        $stmt = $this->pdo->prepare(
            "SELECT * FROM user WHERE email=? OR login=?"
        );

        $stmt->execute($values);

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (is_array($row)) {
            $object
                ->setId($row[self::ID])
                ->setEmail($row[self::EMAIL])
                ->setLogin($row[self::LOGIN])
                ->setPassword($row[self::PASSWORD])
                ->setActiveStatus($row[self::ACTIVE_STATUS])
                ->setCreateDate($row[self::CREATE_DATE])
                ->setUpdateDate($row[self::UPDATE_DATE])
                ->setNotify($row[self::NOTIFY]);
        }
    }

    /**
     * @param Row $object
     */
    public function updatePasswordById(Row $object): void
    {
        /** @var UserRow $object */
        $values = [
            $object->getPassword(),
            $object->getId()
        ];

        $stmt = $this->pdo->prepare(
            "UPDATE user SET password=? WHERE id=?"
        );
        $stmt->execute($values);
    }

    /**
     * Проверка есть ли пользователь с таким email
     *
     * @param Row $object
     * @return bool
     */
    public function hasByEmail(Row $object): bool
    {
        /** @var UserRow $object */
        $values = [
            $object->getEmail(),
        ];

        $stmt = $this->pdo->prepare(
            "SELECT id FROM user WHERE email=? LIMIT 1"
        );

        $stmt->execute($values);

        return $stmt->rowCount() === 1;
    }

    /**
     * Проверка есть ли пользователь с таким логином
     *
     * @param Row $object
     * @return bool
     */
    public function hasByLogin(Row $object): bool
    {
        /** @var UserRow $object */
        $values = [
            $object->getLogin(),
        ];

        $stmt = $this->pdo->prepare(
            "SELECT id FROM user WHERE login=?"
        );

        $stmt->execute($values);

        return $stmt->rowCount() === 1;
    }

    /**
     * @param Row $object
     */
    public function delete(Row $object): void
    {
        /** @var UserRow $object */
        $value = [
            $object->getId()
        ];
        $stmt = $this->pdo->prepare(
            "DELETE FROM user WHERE id=?"
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
            (new UserRow())
                ->setId($row[self::ID])
                ->setEmail($row[self::EMAIL])
                ->setLogin($row[self::LOGIN])
                ->setNotify($row[self::NOTIFY])
                ->setPassword($row[self::PASSWORD])
                ->setActiveStatus($row[self::ACTIVE_STATUS])
                ->setCreateDate($row[self::CREATE_DATE])
                ->setUpdateDate($row[self::UPDATE_DATE]);
    }
}
