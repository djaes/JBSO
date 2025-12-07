<?php
// src/Repository/TypePieceRepository.php
namespace JBSO\Repository;

use JBSO\Entity\TypePiece;
use JBSO\Database\Connection;

class TypePieceRepository
{
    
    private \Doctrine\DBAL\Connection $connection;

    public function __construct()
    {
        $this->connection = Connection::getConnection();
    }
    
    public function findById(int $id): ?TypePiece
    {
        $data = $this->connection->fetchAssociative(
            'SELECT * FROM TypePiece WHERE id = ?',
            [$id]
        );

        if (!$data) {
            return null;
        }

        $typePiece = new TypePiece();
        $typePiece->setId($data['id']);
        $typePiece->setLibelle($data['libelle']);

        return $typePiece;
    }
    
    public function findAll(): array
    {
        $typePiecesData = $this->connection->fetchAllAssociative(
            'SELECT * FROM TypePiece ORDER BY libelle'
        );

        $typePieces = [];
        foreach ($typePiecesData as $data) {
            $typePiece = new TypePiece();
            $typePiece->setId($data['id']);
            $typePiece->setLibelle($data['libelle']);
            $typePieces[] = $typePiece;
        }

        return $typePieces;
    }
    
    public function create(string $libelle): int
    {
        $this->connection->insert('TypePiece', [
            'libelle' => $libelle
        ]);

        return (int) $this->connection->lastInsertId();
    }


    

    
    
    public function save(TypePiece $typePiece): int
    {
        $conn = Connection::getConnection();

        if ($typePiece->getId() === null) {
            // Insertion
            $sql = "INSERT INTO TypePiece (nom) VALUES (:nom)";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['nom' => $typePiece->getNom()]);
            $typePiece->setId($conn->lastInsertId());
        } else {
            // Mise à jour
            $sql = "UPDATE TypePiece SET nom = :nom WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'nom' => $typePiece->getNom(),
                'id' => $typePiece->getId()
            ]);
        }

        return $typePiece->getId();
    }


    public function delete(int $id): bool
    {
        $conn = Connection::getConnection();
        $sql = "DELETE FROM TypePiece WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['id' => $id]);

        return $result;
    }
}
