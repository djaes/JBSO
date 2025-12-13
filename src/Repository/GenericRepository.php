<?php
// src/Repository/GenericRepository.php

namespace JBSO\Repository;

use JBSO\Database\Connection;
use JBSO\Config\TableConfig;

abstract class GenericRepository
{
    protected \Doctrine\DBAL\Connection $connection;
    protected TableConfig $tableConfig;
    protected string $entityName;

    public function __construct()
    {
        $this->connection = Connection::getConnection();
        $this->tableConfig = new TableConfig();
    }

    abstract protected function getEntityName(): string;

    protected function getTableName(): string
    {
        return $this->tableConfig->getTableName($this->getEntityName());
    }

    protected function getEntityClass(): string
    {
        return $this->tableConfig->getEntityClass($this->getEntityName());
    }

    
    public function findAll(): array
    {
        $tableName = $this->getTableName();
        $entityClass = $this->getEntityClass();

        $results = $this->connection->fetchAllAssociative(
            "SELECT * FROM {$tableName} ORDER BY id"
        );

        $entities = [];
        foreach ($results as $data) {
            $entity = new $entityClass();
            $entity->setId($data['id']);

            foreach ($data as $key => $value) {
                $method = 'set' . ucfirst($key);
                if (method_exists($entity, $method)) {
                    $entity->$method($value);
                }
            }

            $entities[] = $entity;
        }

        return $entities;
    }

    public function findById(int $id): ?object
    {
        $tableName = $this->getTableName();
        $entityClass = $this->getEntityClass();

        $data = $this->connection->fetchAssociative(
            "SELECT * FROM {$tableName} WHERE id = ?",
            [$id]
        );

        if (!$data) {
            return null;
        }

        $entity = new $entityClass();
        $entity->setId($data['id']);

        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($entity, $method)) {
                $entity->$method($value);
            }
        }

        return $entity;
    }

    public function create(array $data): int
    {
        $tableName = $this->getTableName();
        $this->connection->insert($tableName, $data);
        return (int) $this->connection->lastInsertId();
    }

    public function delete(int $id): bool
    {
        $tableName = $this->getTableName();
        if (!$this->tableConfig->isValidTable($tableName)) {
            throw new \InvalidArgumentException("Table non autorisée.");
        }

        $result = $this->connection->executeStatement(
            "DELETE FROM {$tableName} WHERE id = ?",
            [$id]
        );

        return $result > 0;
    }

    public function update(int $id, array $data): bool
    {
        $tableName = $this->getTableName();
        $result = $this->connection->update($tableName, $data, ['id' => $id]);
        return $result > 0;
    }
}
