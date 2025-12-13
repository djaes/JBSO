<?php
// src/Entity/Client.php
namespace JBSO\Entity;

class Client
{
    private ?int $id;
    //le nom sera traiter commme label dans les classes generic
    private string $nom;
    private string $adresse;
    private string $telephone;
    private string $email;
    private string $label;

    // Getters et Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getLabel(): string
    {
        return $this->nom;
    }

    public function setLabel(string $label): void
    {
        $this->nom = $label;
    }

    public function getAdresse(): string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    
}
