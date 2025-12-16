<?php
// src/Repository/TypeTacheRepository.php
namespace JBSO\Repository;

class TypeTacheRepository extends AbstractRepository
{
    protected function getTableName(): string
    {
        return 'TypeTache';
    }
    protected function getEntityClass(): string
    {
        return "JBSO\Entity\TypeTache"::class;
    }
    

    // Méthodes spécifiques à TypeTache (si nécessaire)

}
