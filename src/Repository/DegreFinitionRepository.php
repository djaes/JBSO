<?php
namespace JBSO\Repository;

use JBSO\Entity\DegreFinition;
use JBSO\Database\Connection;
use Doctrine\DBAL\Exception;
use PDO;

class DegreFinitionRepository
{
    public function save(DegreFinition $degreFinition): int
    {
        $conn = Connection::getConnection();
        if ($degreFinition->getId() === null) {
            // Insertion
            $sql = "INSERT INTO DegreFinition (libelle) VALUES (:libelle)";
            $conn->executeStatement($sql, ['libelle' => $degreFinition->getLibelle()]);
            $degreFinition->setId($conn->lastInsertId());
            return $degreFinition->getId();
        } else {
            // Mise à jour
            $sql = "UPDATE DegreFinition SET libelle = :libelle WHERE id = :id";
            $conn->executeStatement($sql, [
                'libelle' => $degreFinition->getLibelle(),
                'id' => $degreFinition->getId()
            ]);
            return $degreFinition->getId();
        }
    }

    public function findAll(): array
    {
        $conn = Connection::getConnection();
        $result = $conn->executeQuery("SELECT * FROM DegreFinition");
        $degres = [];
        while (($row = $result->fetchAssociative()) !== false) {
            $degre = new DegreFinition();
            $degre->setId($row['id']);
            $degre->setLibelle($row['libelle']);
            $degres[] = $degre;
        }
        return $degres;
    }

    public function findById(int $id): ?DegreFinition
    {
        $conn = Connection::getConnection();
        $result = $conn->executeQuery("SELECT * FROM DegreFinition WHERE id = :id", ['id' => $id]);
        $row = $result->fetchAssociative();
        if (!$row) {
            return null;
        }
        $degre = new DegreFinition();
        $degre->setId($row['id']);
        $degre->setLibelle($row['libelle']);
        return $degre;
    }

    public function delete(int $id): void
    {
        $conn = Connection::getConnection();
        $conn->executeStatement("DELETE FROM DegreFinition WHERE id = :id", ['id' => $id]);
    }
}
