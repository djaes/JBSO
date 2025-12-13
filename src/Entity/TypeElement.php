<?php
// src/Entity/TypeElement.php
namespace JBSO\Entity;


class TypeElement
{
    private ?int $id;
    private string $label;
    
    // Getters 
    public function getId(): ?int { return $this->id; }
    public function getLabel(): string { return $this->label; }
    
    // Setters
    public function setId(?int $id): void { $this->id = $id; }
    public function setLabel(string $label): void { $this->label = $label; }
    
    
    

}
