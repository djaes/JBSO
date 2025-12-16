<?php
// src/Entity/Client.php
namespace JBSO\Entity;

class Client extends AbstractEntity
{
    private string $adresse;
    private string $telephone;
    private string $email;
    private int $cp;
    private string $ville;
    // Getters et Setters
    
    public function getAdresse(): string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }
    public function getCp(): int
    {
        return $this->cp;
    }

    public function setCp(int $cp): void
    {
        $this->cp = $cp;
    }
    public function getVille(): string
    {
        return $this->ville;
    }

    public function setVille(string $ville): void
    {
        $this->ville = $ville;
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
