<?php
// src/Entity/TypeTache.php
namespace JBSO\Entity;

use JBSO\Database\Connection;

class TypeTache
{
    private ?int $id;
    private string $libelle;
    private string $description;

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getLibelle(): string { return $this->libelle; }
    public function getDescription(): string { return $this->description; }

    //Setters
    public function setId(?int $id): void { $this->id = $id; }  
    public function setLibelle(string $libelle): void { $this->libelle = $libelle; }
    public function setDescription(string $description): void { $this->description = $description; }

    
    public static function findById(int $id): ?self
    {
        $data = Connection::getConnection()->fetchAssociative(
            'SELECT * FROM TypeTache WHERE id = ?',
            [$id]
        );

        if (!$data) {
            return null;
        }

        $typeTache = new self();
        $typeTache->setId($data['id']);
        $typeTache->setLibelle($data['libelle']);
        $typeTache->setDescription($data['description']);

        return $typeTache;
    }



}
