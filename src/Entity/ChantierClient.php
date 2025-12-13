<?php
// src/Entity/ChantierClient.php
namespace JBSO\Entity;

class ChantierClient
{
     private ?int $id;
    private string $adresse;
    private ?string $dateDebut;
    private ?string $dateFin;
    private int $finitionIdGlobal;
    private int $couleurIdMurGlobal;
    private int $couleurIdPlafondGlobal;
    private int $clientId;
    private ?string $label;

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): string
    {
        return $this->adresse;
    }

    public function getDateDebut(): ?string
    {
        return $this->date_debut;
    }

    public function getDateFin(): ?string
    {
        return $this->date_fin;
    }

    public function getCouleurIdPlafondGlobal(): int
    {
        return $this->finition_id_global;
    }

    public function getCouleurIdMurGlobal(): int
    {
        return $this->couleur_id_mur_global;
    }

    public function getCouleurIdPlafondGlobal(): int
    {
        return $this->couleur_id_plafond_global;
    }

    public function getClientId(): int
    {
        return $this->client_id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    // Setters
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }

    public function setDateDebut(?string $dateDebut): void
    {
        $this->date_debut = $dateDebut;
    }

    public function setDateFin(?string $dateFin): void
    {
        $this->date_fin = $dateFin;
    }

    public function setFinitionIdGlobal(int $finitionIdGlobal): void
    {
        $this->finition_id_global = $finitionIdGlobal;
    }

    public function setCouleurIdMurGlobal(int $couleurIdMurGlobal): void
    {
        $this->couleur_id_mur_global = $couleurIdMurGlobal;
    }

    public function setCouleurIdPlafondGlobal(int $couleurIdPlafondGlobal): void
    {
        $this->couleur_id_plafond_global = $couleurIdPlafondGlobal;
    }

    public function setClientId(int $clientId): void
    {
        $this->client_id = $clientId;
    }

    public function setLabel(?string $label): void
    {
        $this->label = $label;
    }

}
