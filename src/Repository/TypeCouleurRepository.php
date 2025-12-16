<?php
// src/Repository/TypeCouleurRepository.php
namespace JBSO\Repository;

class TypeCouleurRepository extends AbstractRepository
{
    protected function getTableName(): string
    {
        return 'TypeCouleur';
    }
    protected function getEntityClass(): string
    {
        return "JBSO\Entity\TypeCouleur"::class;
    }
    

    // Méthodes spécifiques à TypeCouleur (si nécessaire)


}
