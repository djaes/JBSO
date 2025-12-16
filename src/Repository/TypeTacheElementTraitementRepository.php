<?php
// src/Repository/TypeTacheElementTraitementRepository.php
namespace JBSO\Repository;

class TypeTacheElementTraitementRepository extends AbstractRepository
{
    protected function getTableName(): string
    {
        return 'TypeTacheElementTraitement';
    }
    protected function getEntityClass(): string
    {
        return "JBSO\Entity\TypeTacheElementTraitement"::class;
    }
    // Méthodes spécifiques à TypeTacheElementTraitement (si nécessaire)
    

}
