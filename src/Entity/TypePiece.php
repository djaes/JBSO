<?php
// src/Entity/TypePiece.php
namespace JBSO\Entity;

use JBSO\Database\Connection;

class TypePiece
{
    private ?int $id;
    private string $libelle;

    // Getters 
    public function getId(): ?int { return $this->id; }
    public function getLibelle(): string { return $this->libelle; }

    //Setters
    public function setId(?int $id): void { $this->id = $id; }
    public function setLibelle(string $libelle): void { $this->libelle = $libelle; }

    /**
     * Trouve un type de piece par son ID.
     */
    public static function findById(int $id): ?self
    {
        $data = Connection::getConnection()->fetchAssociative(
            'SELECT * FROM TypePiece WHERE id = ?',
            [$id]
        );

        if (!$data) {
            return null;
        }

        $typePiece = new self();
        $typePiece->setId($data['id']);
        $typePiece->setLibelle($data['libelle']);

        return $typePiece;
    }


}

?>