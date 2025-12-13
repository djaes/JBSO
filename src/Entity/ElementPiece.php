<?php
// src/Entity/ElementPiece.php
namespace JBSO\Entity;

class ElementPiece
{
    private ?int $id;
    private string $label;
    private int $typeTraitementId;
    private ?int $typeFinitionId;
    private ?int $typeCouleurId;
    private int $pieceId;
    private int $typeElementId;

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getTypeTraitementId(): int
    {
        return $this->type_traitement_id;
    }

    public function getTypeFinitionId(): ?int
    {
        return $this->type_finition_id;
    }

    public function getTypeCouleurId(): ?int
    {
        return $this->type_couleur_id;
    }

    public function getPieceId(): int
    {
        return $this->piece_id;
    }

    public function getTypeElementId(): int
    {
        return $this->type_element_id;
    }

    // Setters
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function setTypeTraitement(int $typeTraitement): void
    {
        $this->type_traitement_id = $typeTraitement;
    }

    public function setTypeFinitionId(?int $typeFinitionId): void
    {
        $this->type_finition_id = $typeFinitionId;
    }

    public function setTypeCouleurId(?int $typeCouleurId): void
    {
        $this->typ_couleur_id = $typeCouleurId;
    }

    public function setPieceId(int $pieceId): void
    {
        $this->piece_id = $pieceId;
    }

    public function setTypeElementId(int $typeElementId): void
    {
        $this->type_element_id = $typeElementId;
    }
}