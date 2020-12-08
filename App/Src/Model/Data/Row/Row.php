<?php

namespace App\Src\Model\Data\Row;

abstract class Row
{
    protected $id;

    abstract public function getId(): ?int;
    abstract public function setId(int $id);
}