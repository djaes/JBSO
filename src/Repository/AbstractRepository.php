<?php
// src/Repository/AbstractRepository.php
namespace JBSO\Repository;

use JBSO\Database\Connection;
use JBSO\Entity\AbstractEntityInterface;

abstract class AbstractRepository implements AbstractRepositoryInterface
{
    protected \Doctrine\DBAL\Connection $connection;

    public function __construct()
    {
        $this->connection = Connection::getConnection();
    }

    abstract protected function getTableName(): string;
    abstract protected function getEntityClass(): string;

    private function renameKey($string)
    {
        return  ucfirst(preg_replace_callback(
        '/_([a-z])/',
            function ($matches) {
                return strtoupper($matches[1]);
            },
            $string
        ));
        
        
    }

    public function findAll(): array
    {
        $tableName = $this->getTableName();
        $results = $this->connection->fetchAllAssociative(
            "SELECT * FROM {$tableName} ORDER BY id"
        );
        $entities = [];
        foreach ($results as $data) {
            $entity = $this->createEntityFromArray($data);
            
            $entities[] = $entity;
            
        }
        return $entities;
    }

    public function findById(int $id): ?AbstractEntityInterface
    {
        $data = $this->connection->fetchAssociative("SELECT * FROM {$this->getTableName()} WHERE id = ?", [$id]);
        if (!$data) {
            return null;
        }
        return $this->createEntityFromArray($data);
    }

    public function create(array $data): int
    {
        $this->connection->insert($this->getTableName(), $data);
        return (int) $this->connection->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $result = $this->connection->update($this->getTableName(), $data, ['id' => $id]);
        return $result > 0;
    }

    public function delete(int $id): bool
    {
        $result = $this->connection->executeStatement("DELETE FROM {$this->getTableName()} WHERE id = ?", [$id]);
        return $result > 0;
    }

    protected function createEntityFromArray(array $data): AbstractEntityInterface
    {
        $entityClass = $this->getEntityClass();
        $entity = new $entityClass();
        $entity->setId($data['id']);

        foreach ($data as $key => $value) {
            $method = 'set' . $this->renameKey($key);
            if (method_exists($entity, $method)) {
                $entity->$method($value);
            }
        }
        return $entity;
    }
}
