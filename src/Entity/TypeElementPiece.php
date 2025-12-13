<?php
// src/Entity/TypeElementPiece.php
namespace JBSO\Entity;

class TypeElementPiece
{
    private $id;
    private $typePiece;
    private $typeElement;
    private $label;

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getTypePiece(): int{ return $this->typePiece; }
    public function getTypeElement(): int{ return $this->typeElement; }
    public function getLabel(): ?string{ return $this->label;}
    
    //Setters
    public function setId(?int $id): void { $this->id = $id; }  
    public function setTypePiece(int $typePiece): void { $this->typePiece = $typePiece; }
    public function setTypeElement(int $typeElement): void { $this->typeElement = $typeElement; }
    public function setLabel(?string $label): void{ $this->label = $label; }
    
}
