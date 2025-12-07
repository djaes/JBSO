<?php
// src/Repository/TypeFinitionRepository.php
namespace JBSO\Repository;

use JBSO\Entity\TypeFinition;
use JBSO\Database\Connection;

class TypeFinitionRepository
{
    private \Doctrine\DBAL\Connection $connection;

    public function __construct()
    {
        $this->connection = Connection::getConnection();
    }

    public function findById(int $id): ?TypeFinition
    {
        $data = $this->connection->fetchAssociative(
            'SELECT * FROM TypeFinition WHERE id = ?',
            [$id]
        );

        if (!$data) {
            return null;
        }

        $typeFinition = new TypeFinition();
        $typeFinition->setId($data['id']);
        $typeFinition->setLibelle($data['libelle']);

        return $typeFinition;
    }

    public function findAll(): array
    {
        $typeFinitionsData = $this->connection->fetchAllAssociative(
            'SELECT * FROM TypeFinition ORDER BY libelle'
        );

        $typeFinitions = [];
        foreach ($typeFinitionsData as $data) {
            $typeFinition = new TypeFinition();
            $typeFinition->setId($data['id']);
            $typeFinition->setLibelle($data['libelle']);
            $typeFinitions[] = $typeFinition;
        }

        return $typeFinitions;
    }

    public function create(string $libelle): int
    {
        $this->connection->insert('TypeFinition', [
            'libelle' => $libelle
        ]);

        return (int) $this->connection->lastInsertId();
    }


    
}
