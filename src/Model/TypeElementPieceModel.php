<?php
namespace JBSO\Model;

use Doctrine\DBAL\Connection;

class TypeElementPieceModel
{
    private $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function getAllTypePieces()
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('*')
            ->from('TypePiece');

        $stmt = $queryBuilder->executeQuery();
        return $stmt->fetchAllAssociative();
    }

    public function getAllTypeElements()
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('*')
            ->from('TypeElement');

        $stmt = $queryBuilder->executeQuery();
        return $stmt->fetchAllAssociative();
    }

    public function getTypeElementsByTypePiece($typePieceId)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('*')
            ->from('TypeElementPiece')
            ->where('type_piece = ?')
            ->setParameter(0, $typePieceId);

        $stmt = $queryBuilder->executeQuery();
        return $stmt->fetchAllAssociative();
    }

    public function saveTypeElementsForTypePiece($typePieceId, $typeElementIds)
    {
        // Supprimer les anciennes associations
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->delete('TypeElementPiece')
            ->where('type_piece = ?')
            ->setParameter(0, $typePieceId);

        $queryBuilder->executeStatement();

        // Ajouter les nouvelles associations
        foreach ($typeElementIds as $typeElementId) {
            $this->db->insert('TypeElementPiece', [
                'type_piece' => $typePieceId,
                'type_element' => $typeElementId,
            ]);
        }
    }
}
