<?php
// src/Repository/TypeTraitementRepository.php
namespace JBSO\Repository;

class TypeTraitementRepository extends AbstractRepository
{
    protected function getTableName(): string
    {
        return 'TypeTraitement';
    }
    protected function getEntityClass(): string
    {
        return "JBSO\Entity\TypeTraitement"::class;
    }
    

    // Méthodes spécifiques à TypeTraitement (si nécessaire)


}
