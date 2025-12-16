<?php
// src/Entity/TypeElementPiece.php
namespace JBSO\Entity;

class TypeElementPiece extends AbstractEntity
{
    protected  ?int $type_element_id;
    protected  ?int $type_piece_id;
    
    // Getters 
    public function getTypeElementId(): ?int { return $this->type_element_id; }
    public function getTypePieceId(): ?int { return $this->type_piece_id; }

    // Setters
    public function setTypeElementId(?int $type_element_id): void { $this->type_element_id = $type_element_id; }
    public function setTypePieceId(?int $type_piece_id): void { $this->type_piece_id = $type_piece_id; }
}
