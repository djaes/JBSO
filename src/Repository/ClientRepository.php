<?php
// src/Repository/ClientRepository.php
namespace JBSO\Repository;

class ClientRepository extends AbstractRepository
{
    protected function getTableName(): string
    {
        return 'Client';
    }
    protected function getEntityClass(): string
    {
        return "JBSO\Entity\Client"::class;
    }
    // Méthodes spécifiques à Client (si nécessaire)
    
}
