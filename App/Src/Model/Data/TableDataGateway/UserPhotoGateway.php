<?php

namespace App\Src\Model\Data\TableDataGateway;

use App\Src\Model\Data\Criteria\GalleryCriteria;
use App\Src\Model\Data\Entity\GalleryEntity;
use App\Src\Model\Data\Row\Row;
use App\Src\Model\Data\Row\UserPhotoRow;

class UserPhotoGateway extends TableDataGateway
{
    public const
        ID         = 'id',
        USER_ID    = 'user_id',
        NAME       = 'name',
        TITLE      = 'title',
        PHOTO      = 'photo',
        CREATED_AT = 'created_at'
    ;

    /**
     * @return UserPhotoGateway
     */
    public static function create(): UserPhotoGateway
    {
        return new self();
    }

    /**
     * @param Row $object
     */
    protected function insert(Row $object): void
    {
        /** @var UserPhotoRow $object */
        $values = [
            $object->getUserId(),
            $object->getName(),
            $object->getTitle(),
            $object->getPhoto()
        ];

        $stmt = $this->pdo->prepare(
            "INSERT INTO user_photo (user_id, name, title, photo) VALUES (?, ?, ?, ?)"
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
            "DELETE FROM user_photo WHERE id=?"
        );
        $stmt->execute($value);
    }

    /**
     * @param Row $object
     */
    protected function update(Row $object): void
    {
        /** @var UserPhotoRow $object */
        $values = [
            $object->getUserId(),
            $object->getName(),
            $object->getPhoto(),
            $object->getId()
        ];

        $stmt = $this->pdo->prepare(
            "UPDATE user_photo SET user_id=?, name=?, photo=? WHERE id=?"
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
            "SELECT * FROM user_photo WHERE id=?"
        );
    }

    /**
     * @param Row $object
     * @return array|null
     */
    public function getByUserId(Row $object): ?array
    {
        /** @var UserPhotoRow $object */
        $values = [
            $object->getUserId(),
        ];

        $stmt = $this->pdo->prepare(
            "SELECT * FROM user_photo WHERE user_id=?"
        );

        $stmt->execute($values);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if (!is_array($rows)) {
            return null;
        }

        foreach ($rows as $row) {
            $result[] = $this->createObject($row);
        }

        return $result;
    }

    /**
     * @param Row $object
     * @return \PDOStatement
     */
    protected function selectAll(Row $object): \PDOStatement
    {
        return $this->pdo->prepare(
            "SELECT * FROM user_photo WHERE id=?"
        );
    }

    /**
     * @return int
     */
    public function getCountRows(): int
    {
        $stmt = $this->pdo->prepare(
            "SELECT count(id) FROM user_photo"
        );
        $stmt->execute();
        $tmp = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $tmp['count(id)'];
    }

    /**
     * @param GalleryCriteria $galleryCriteria
     * @return array
     */
    public function getGalleryByCriteria(GalleryCriteria $galleryCriteria): array
    {
        $result = [];

        $values = [
            $galleryCriteria->getOffset(),
            $galleryCriteria->getChunk()
        ];

        $stmt = $this->pdo->prepare(
            "SELECT user_photo.id, user_photo.created_at, user_photo.title, user_photo.photo, user.login FROM user_photo JOIN user ON user.id = user_photo.user_id  ORDER BY created_at DESC LIMIT ?, ?"
        );
        $stmt->execute($values);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if (!is_array($rows)) {
            return $result;
        }

        $galleryEntity = new GalleryEntity();

        foreach ($rows as $row) {
            $result[] = $galleryEntity->createEntity($row);
        }

        return $result;
    }

    /**
     * @param array $row
     * @return Row
     */
    protected function createObject(array $row): Row
    {
        return
            (new UserPhotoRow())
                ->setId($row[self::ID])
                ->setName($row[self::NAME])
                ->setTitle($row[self::TITLE])
                ->setPhoto($row[self::PHOTO])
                ->setUserId($row[self::USER_ID])
                ->setCreatedAt($row[self::CREATED_AT])
            ;
    }
}
