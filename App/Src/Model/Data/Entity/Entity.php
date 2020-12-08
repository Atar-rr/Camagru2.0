<?php


namespace App\Src\Model\Data\Entity;


abstract class Entity
{
    protected $id;

    abstract public function getId(): ?int;
    abstract public function setId(int $id);
}