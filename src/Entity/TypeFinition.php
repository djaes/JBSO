<?php
// src/Entity/TypeFinition.php
namespace JBSO\Entity;

use JBSO\Database\Connection;

class TypeFinition
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
     * Trouve un degré de finition par son ID.
     */
    public static function findById(int $id): ?self
    {
        $data = Connection::getConnection()->fetchAssociative(
            'SELECT * FROM TypeFinition WHERE id = ?',
            [$id]
        );

        if (!$data) {
            return null;
        }

        $typeFinition = new self();
        $typeFinition->setId($data['id']);
        $typeFinition->setLibelle($data['libelle']);

        return $typeFinition;
    }

}
?>