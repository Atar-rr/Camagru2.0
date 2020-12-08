<?php

namespace App\Src\Model\Data\TableDataGateway;

use App\Src\Model\Data\Registry;
use App\Src\Model\Data\Row\Row;

abstract class TableDataGateway
{
    protected $pdo;

    /**
     * TableDataGateway constructor.
     */
    public function __construct()
    {
        $this->pdo = Registry::getPdo();
    }

    /**
     * Выборка одной строки из таблицы
     *
     * @param Row $object
     * @return Row|null
     */
    public function getRow(Row $object): ?Row
    {
        $stmt = $this->select($object);
        $stmt->execute([(int)$object->getId()]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row === false || !is_array($row)) {
            return null;
        }

        return $this->createObject($row);
    }

    /**
     * Выборка всех подходящиъ строк из таблицы
     *
     * @param Row $object
     * @return Row[]|null
     */
    public function getRowSet(Row $object): ?array
    {
        $result = [];
        $stmt = $this->selectAll($object);
        $stmt->execute([$object->getId()]);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (!is_array($rows)) {
            return null;
            #Todo или исключение
        }
        foreach ($rows as $row) {
            $result[] = $this->createObject($row);
        }

        return $result;
    }

    /**
     * Вставляем или обновляем строку в таблице
     *
     * @param Row $object
     */
    public function save(Row $object)
    {
        if ($object->getId() !== null) {
            $this->update($object);
        } else {
            $this->insert($object);
        }
    }

    /**
     * Создание экзепляра нужногоGateway
     *
     * @return mixed
     */
    abstract public static function create();

    /**
     * @param Row $object
     */
    abstract protected function insert(Row $object);

    /**
     * @param Row $object
     */
    abstract public function delete(Row $object);

    /**
     * @param Row $object
     */
    abstract protected function update(Row $object);

    /**
     * @param Row $object
     * @return \PDOStatement
     */
    abstract protected function select(Row $object): \PDOStatement;

    /**
     * @param Row $object
     * @return \PDOStatement
     */
    abstract protected function selectAll(Row $object): \PDOStatement;

    /**
     * Создаем объект из результата на базе одной строки из таблицы
     *
     * @param array $row
     * @return Row
     */
    abstract protected function createObject(array $row): Row;
}
