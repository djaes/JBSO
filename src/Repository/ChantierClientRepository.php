<?php
// src/Repository/ChantierClientRepository.php
namespace JBSO\Repository;

class ChantierClientRepository extends AbstractRepository
{
    protected function getTableName(): string
    {
        return 'ChantierClient';
    }
    protected function getEntityClass(): string
    {
        return "JBSO\Entity\ChantierClient"::class;
    }
    
    
    // Méthodes spécifiques à ChantierClientRepository (si nécessaire)

    
}
