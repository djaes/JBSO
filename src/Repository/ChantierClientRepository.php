<?php
// src/Repository/ChantierClientRepository.php
namespace JBSO\Repository;

class ChantierClientRepository extends GenericRepository
{
    protected function getEntityName(): string
    {
        return 'ChantierClient';
    }
}
