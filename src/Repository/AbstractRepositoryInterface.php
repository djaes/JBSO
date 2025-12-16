<?php
// src/Repository/AbstractRepositoryInterface.php
namespace JBSO\Repository;

use JBSO\Entity\AbstractEntityInterface;

interface AbstractRepositoryInterface
{
    
    
    public function findAll(): array;
    
    public function findById(int $id): ?AbstractEntityInterface;

    public function create(array $data): int;
    
    public function delete(int $id): bool;
    
    public function update(int $id, array $data): bool;
    
}
