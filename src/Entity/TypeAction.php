<?php
// src/Entity/TypeAction.php
namespace JBSO\Entity;

use JBSO\Database\Connection;

class TypeAction
{
    private ?int $id;
    private string $libelle;

    // Getters 
    public function getId(): ?int { return $this->id; }
    public function getLibelle(): string { return $this->libelle; }

    // Setters
    public function setId(?int $id): void { $this->id = $id; }
    public function setLibelle(string $libelle): void { $this->libelle = $libelle; }

    
    /**
     * Trouve un Type d'action par son ID.
     */
    public static function findById(int $id): ?self
    {
        $data = Connection::getConnection()->fetchAssociative(
            'SELECT * FROM TypeAction WHERE id = ?',
            [$id]
        );

        if (!$data) {
            return null;
        }

        $typeAction = new self();
        $typeAction->setId($data['id']);
        $typeAction->setLibelle($data['libelle']);

        return $typeAction;
    }


}
