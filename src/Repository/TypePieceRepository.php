<?php
// src/Repository/TypePieceRepository.php
namespace JBSO\Repository;

class TypePieceRepository extends AbstractRepository
{
    protected function getTableName(): string
    {
        return 'TypePiece';
    }
    protected function getEntityClass(): string
    {
        return "JBSO\Entity\TypePiece"::class;
    }
    
    // Méthodes spécifiques à TypePiece (si nécessaire)
}
