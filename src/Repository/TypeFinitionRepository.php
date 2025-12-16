<?php
// src/Repository/TypeFinitionRepository.php
namespace JBSO\Repository;

class TypeFinitionRepository extends AbstractRepository
{
    protected function getTableName(): string
    {
        return 'TypeFinition';
    }
    protected function getEntityClass(): string
    {
        return "JBSO\Entity\TypeFinition"::class;
    }
    
    
    // Méthodes spécifiques à TypeFinition (si nécessaire)

    
}
