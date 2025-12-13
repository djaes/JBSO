<?php
namespace JBSO\Repository;

use JBSO\Entity\Client;
use JBSO\Database\Connection;

class ClientRepository
{
    protected function getEntityName(): string
    {
        return 'Client';
    }
    
}
