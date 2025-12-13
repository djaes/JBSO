<?php
// src/Config/TableConfig.php

namespace JBSO\Config;

class TableConfig
{
    private array $config;

    public function __construct()
    {
        $this->config = parse_ini_file(__DIR__ . '/ini/tableConfig.ini', true);
    }

    public function getTableName(string $entityName): ?string
    {
        return $this->config[$entityName]['table_name'] ?? null;
    }

    public function getEntityClass(string $entityName): ?string
    {
        return $this->config[$entityName]['entity_class'] ?? null;
    }

    public function getAllTables(): array
    {
        return array_keys($this->config);
    }

    public function isValidTable(string $tableName): bool
    {
        foreach ($this->config as $entity) {
            if ($entity['table_name'] === $tableName) {
                return true;
            }
        }
        return false;
    }
}
