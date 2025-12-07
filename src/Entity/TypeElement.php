<?php
// src/Entity/TypeElement.php
namespace JBSO\Entity;

use JBSO\Database\Connection;

class TypeElement
{
    private ?int $id;
    private string $libelle;
    private string $traitement;
    
    // Getters 
    public function getId(): ?int { return $this->id; }
    public function getLibelle(): string { return $this->libelle; }
    public function getTraitement(): string { return $this->traitement; }
    
    // Setters
    public function setId(?int $id): void { $this->id = $id; }
    public function setLibelle(string $libelle): void { $this->libelle = $libelle; }
    public function setTraitement(string $traitement): void { $this->traitement = $traitement; }

    
    public static function findById(int $id): ?self
    {
        $data = Connection::getConnection()->fetchAssociative(
            'SELECT * FROM TypeElement WHERE id = ?',
            [$id]
        );

        if (!$data) {
            return null;
        }

        $typeElement = new self();
        $typeElement->setId($data['id']);
        $typeElement->setLibelle($data['libelle']);
        $typeElement->setTraitement($data['traitement']);
        

        return $typeElement;
    }

}
