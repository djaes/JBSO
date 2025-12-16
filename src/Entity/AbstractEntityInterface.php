<?php
// src/Entity/AbstractEntityInterface.php
namespace JBSO\Entity;

use JBSO\Database\Connection;

interface AbstractEntityInterface
{
    public function getId(): ?int;
    public function getLabel(): string ;

    public function setId(?int $id): void;
    public function setLabel(string $label): void ;
}
