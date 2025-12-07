<?php
// src/Repository/TypeActionRepository.php
namespace JBSO\Repository;

use JBSO\Entity\TypeAction;
use JBSO\Database\Connection;

class TypeActionRepository
{
    private \Doctrine\DBAL\Connection $connection;

    public function __construct()
    {
        $this->connection = Connection::getConnection();
    }

    public function findById(int $id): ?TypeAction
    {
        $data = $this->connection->fetchAssociative(
            'SELECT * FROM TypeAction WHERE id = ?',
            [$id]
        );

        if (!$data) {
            return null;
        }

        $typeAction = new TypeAction();
        $typeAction->setId($data['id']);
        $typeAction->setLibelle($data['libelle']);

        return $typeAction;
    }

    public function findAll(): array
    {
        $typeActionsData = $this->connection->fetchAllAssociative(
            'SELECT * FROM TypeAction ORDER BY libelle'
        );

        $typeActions = [];
        foreach ($typeActionsData as $data) {
            $typeAction = new TypeAction();
            $typeAction->setId($data['id']);
            $typeAction->setLibelle($data['libelle']);
            $typeActions[] = $typeAction;
        }

        return $typeActions;
    }

    public function create(string $libelle): int
    {
        $this->connection->insert('TypeAction', [
            'libelle' => $libelle
        ]);

        return (int) $this->connection->lastInsertId();
    }



}
