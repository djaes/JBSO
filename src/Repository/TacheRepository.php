<?php
namespace JBSO\Repository;

use JBSO\Entity\Tache;
use Doctrine\DBAL\Connection;

class TacheRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Trouve une tâche par son ID.
     *
     * @param int $id L'ID de la tâche.
     * @return Tache|null Retourne la tâche ou null si non trouvée.
     */
    public function findById(int $id): ?Tache
    {
        $data = $this->connection->fetchAssociative(
            'SELECT * FROM Tache WHERE id = ?',
            [$id]
        );

        if (!$data) {
            return null;
        }

        $tache = new Tache();
        $tache->setId($data['id']);
        $tache->setNom($data['nom']);
        $tache->setDescription($data['description']);
        // Ajoute d'autres setters si nécessaire

        return $tache;
    }

    public function findAll(): array
    {
        $conn = Connection::getConnection();
        $sql = "SELECT * FROM Tache";
        $stmt = $conn->query($sql);

        $taches = [];
        while ($row = $stmt->fetchAssociative()) {
            $tache = new Tache();
            $tache->setId($row['id']);
            $tache->setNom($row['nom']);
            $tache->setDescription($row['description']);
            $taches[] = $tache;
        }

        return $taches;
    }

    public function delete(int $id): bool
    {
        $conn = Connection::getConnection();
        $sql = "DELETE FROM Tache WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['id' => $id]);

        return $result;
    }
}
