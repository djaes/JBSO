<?php
// src/Repository/ElementPieceRepository.php
namespace JBSO\Repository;

class ElementPieceRepository extends GenericRepository
{
    protected function getEntityName(): string
    {
        return 'ElementPiece';
    }
}
