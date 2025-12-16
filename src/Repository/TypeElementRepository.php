<?php
// src/Repository/TypeElementRepository.php
namespace JBSO\Repository;

class TypeElementRepository extends AbstractRepository 
{
    protected function getTableName(): string
    {
        return 'TypeElement';
    }
    protected function getEntityClass(): string
    {
        return "JBSO\Entity\TypeElement"::class;
    }
    // Méthodes spécifiques à TypeElement (si nécessaire)
}
