<?php
// src/Entity/TypeCouleur.php
namespace JBSO\Entity;

use JBSO\Database\Connection;

class TypeCouleur
{
    private int $id;
    private string $libelle;
    private ?string $codeCouleur = null;

    // Getters
    public function getId(): int { return $this->id; }
    public function getLibelle(): string { return $this->libelle; }
    public function getCodeCouleur(): ?string { return $this->codeCouleur; }
    
    // Setters
    public function setId(int $id): void { $this->id = $id; }
    public function setLibelle(string $libelle): void { $this->libelle = $libelle; }
    public function setCodeCouleur(string $codeCouleur): void { $this->codeCouleur = $codeCouleur; }


    public static function findById(int $id): ?self
    {
        $data = Connection::getConnection()->fetchAssociative(
            'SELECT * FROM TypeCouleur WHERE id = ?',
            [$id]
        );

        if (!$data) {
            return null;
        }

        $typeCouleur = new self();
        $typeCouleur->setId($data['id']);
        $typeCouleur->setLibelle($data['libelle']);
        $typeCouleur->setCodeHexa($data['code_hexa']);

        return $typeCouleur;
    }
}
