<?php
// src/Repository/TypeTacheRepository.php
namespace JBSO\Repository;

use JBSO\Entity\TypeTache;
use JBSO\Database\Connection;

class TypeTacheRepository
{
    private \Doctrine\DBAL\Connection $connection;

    public function __construct()
    {
        $this->connection = Connection::getConnection();
    }

    public function findById(int $id): ?TypeTache
    {
        $data = $this->connection->fetchAssociative(
            'SELECT * FROM TypeTache WHERE id = ?',
            [$id]
        );

        if (!$data) {
            return null;
        }

        $typeTache = new TypeTache();
        $typeTache->setId($data['id']);
        $typeTache->setLibelle($data['libelle']);
        $typeTache->setDescription($data['description']);

        return $typeTache;
    }

    public function findAll(): array
    {
        $typeTachesData = $this->connection->fetchAllAssociative(
            'SELECT * FROM TypeTache ORDER BY libelle'
        );

        $typeTaches = [];
        foreach ($typeTachesData as $data) {
            $typeTache = new TypeTache();
            $typeTache->setId($data['id']);
            $typeTache->setLibelle($data['libelle']);
            $typeTache->setDescription($data['description']);
            $typeTaches[] = $typeTache;
        }

        return $typeTaches;
    }

    public function create(string $libelle, string $description): int
    {
        $this->connection->insert('TypeTache', [
            'libelle' => $libelle,
            'description' => $description
        ]);

        return (int) $this->connection->lastInsertId();
    }

}
