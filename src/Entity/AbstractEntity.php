<?php
// src/Entity/AbstractEntity.php
namespace JBSO\Entity;

abstract class AbstractEntity implements AbstractEntityInterface
{
    protected  ?int $id;
    protected  string $label;

    // Getters 
    public function getId(): ?int { return $this->id; }
    public function getLabel(): string { return $this->label; }

    // Setters
    public function setId(?int $id): void { $this->id = $id; }
    public function setLabel(string $label): void { $this->label = $label; }

}
