<?php
// src/Entity/TacheElement.php
namespace JBSO\Entity;

class TacheElement
{
    private ?int $id;
    private string $label;
    private int $typeTETId;
    private ?int $elementId;
    private ?int $ordre;
    private int $statut;
    
    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getTETId(): int
    {
        return $this->type_T_E_T_id;
    }

    public function getElementId(): ?int
    {
        return $this->element_id;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function getStatut(): int
    {
        return $this->statut;
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

    public function setTETId(int $typeTETId): void
    {
        $this->type_T_E_T_id = $typeTETId;
    }

    public function setElementId(?int $elementId): void
    {
        $this->element_id = $elementId;
    }

    public function setordre(?int $ordre): void
    {
        $this->ordre = $ordre;
    }

    public function setStatut(int $statut): void
    {
        $this->statut = $statut;
    }

}