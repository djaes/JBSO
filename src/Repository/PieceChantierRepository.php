<?php
// src/Repository/PieceChantierRepository.php
namespace JBSO\Repository;

class PieceChantierRepository extends GenericRepository
{
    protected function getEntityName(): string
    {
        return 'PieceChantier';
    }
}
