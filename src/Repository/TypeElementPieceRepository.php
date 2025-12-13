<?php
// src/Repository/TypeElementPieceRepository.php
namespace JBSO\Repository;

use JBSO\Database\Connection;
use JBSO\Config\TableConfig;

class TypeElementPieceRepository extends GenericRepository
{
    protected function getEntityName(): string
    {
        return 'TypeElementPiece';
    }

    
    public function saveTypeElementsForTypePiece($typePieceId, $typeElementIds)
    {
        // Supprimer les anciennes associations
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->delete('TypeElementPiece')
            ->where('type_piece = :type_piece_id')
            ->setParameter('type_piece_id', $typePieceId)
            ->executeStatement();

        // Ajouter les nouvelles associations
        foreach ($typeElementIds as $typeElementId) {
            $queryBuilder = $this->connection->createQueryBuilder();
            $queryBuilder
                ->insert('TypeElementPiece')
                ->values([
                    'type_piece' => ':type_piece_id',
                    'type_element' => ':type_element_id'
                ])
                ->setParameter('type_piece_id', $typePieceId)
                ->setParameter('type_element_id', $typeElementId)
                ->executeStatement();
        }
    }

    public function deleteTypeElementPiece($typePieceId, $typeElementId)
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->delete('TypeElementPiece')
            ->where('type_piece = :type_piece_id')
            ->andWhere('type_element = :type_element_id')
            ->setParameter('type_piece_id', $typePieceId)
            ->setParameter('type_element_id', $typeElementId)
            ->executeStatement();
    }
}
