<?php
// src/Repository/TypeCouleurRepository.php
namespace JBSO\Repository;

use JBSO\Entity\TypeCouleur;
use JBSO\Database\Connection;

class TypeCouleurRepository
{
    private \Doctrine\DBAL\Connection $connection;

    public function __construct()
    {
        $this->connection = Connection::getConnection();
    }

    public function findById(int $id): ?TypeCouleur
    {
        $data = $this->connection->fetchAssociative(
            'SELECT * FROM TypeCouleur WHERE id = ?',
            [$id]
        );

        if (!$data) {
            return null;
        }

        $typeCouleur = new TypeCouleur();
        $typeCouleur->setId($data['id']);
        $typeCouleur->setLibelle($data['libelle']);
        $typeCouleur->setCodeHexa($data['code_hexa']);

        return $typeCouleur;
    }

    public function findAll(): array
    {
        $typeCouleursData = $this->connection->fetchAllAssociative(
            'SELECT * FROM TypeCouleur ORDER BY libelle'
        );

        $typeCouleurs = [];
        foreach ($typeCouleursData as $data) {
            $typeCouleur = new TypeCouleur();
            $typeCouleur->setId($data['id']);
            $typeCouleur->setLibelle($data['libelle']);
            $typeCouleur->setCodeHexa($data['code_hexa']);
            $typeCouleurs[] = $typeCouleur;
        }

        return $typeCouleurs;
    }

    public function create(string $libelle): int
    {
        $this->connection->insert('TypeCouleur', [
            'libelle' => $libelle
        ]);

        return (int) $this->connection->lastInsertId();
    }



}
