<?php
// src/Repository/TypePieceRepository.php
namespace JBSO\Repository;

class TypePieceRepository extends GenericRepository
{
    protected function getEntityName(): string
    {
        return 'TypePiece';
    }

    // Méthodes spécifiques à TypePiece (si nécessaire)
}
