<?php
// src/Entity/PieceChantier.php
namespace JBSO\Entity;

class PieceChantier
{
    private ?int $id;
    private int $typePieceId;
    private ?int $etage;
    private string $label;
    private ?int $typeFinitionId;
    private ?int $typeCouleurIdMur;
    private ?int $typeCouleurIdPlafond;
    private int $chantierId;

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypePieceId(): int
    {
        return $this->type_piece_id;
    }

    public function getEtage(): ?int
    {
        return $this->etage;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getTypeFinitionId(): ?int
    {
        return $this->type_finition_id;
    }

    public function getTypeCouleurIdMur(): ?int
    {
        return $this->type_couleur_id_mur;
    }

    public function getTypeCouleurIdPlafond(): ?int
    {
        return $this->type_couleur_id_plafond;
    }

    public function getChantierId(): int
    {
        return $this->chantier_id;
    }

    // Setters
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setTypePieceId(int $typePieceId): void
    {
        $this->type_piece_id = $typePieceId;
    }

    public function setEtage(?int $etage): void
    {
        $this->etage = $etage;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function setTypeFinitionId(?int $typeFinitionId): void
    {
        $this->type_finition_id = $typeFinitionId;
    }

    public function setTypeCouleurIdMur(?int $typeCouleurIdMur): void
    {
        $this->type_couleur_id_mur = $typeCouleurIdMur;
    }

    public function setTypeCouleurIdPlafond(?int $typeCouleurIdPlafond): void
    {
        $this->type_couleur_id_plafond = $typeCouleurIdPlafond;
    }

    public function setChantierId(int $chantierId): void
    {
        $this->chantier_id = $chantierId;
    }
}