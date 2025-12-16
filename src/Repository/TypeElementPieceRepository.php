<?php
// src/Repository/TypeElementPieceRepository.php
namespace JBSO\Repository;

class TypeElementPieceRepository extends AbstractRepository 
{
    protected function getTableName(): string
    {
        return 'TypeElementPiece';
    }
    protected function getEntityClass(): string
    {
        return "JBSO\Entity\TypeElementPiece"::class;
    }
    // Méthodes spécifiques à TypeElement (si nécessaire)
    
    
}
