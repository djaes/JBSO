<?php
// src/Repository/TypeElementRepository.php
namespace JBSO\Repository;

use JBSO\Entity\TypeElement;
use JBSO\Database\Connection; // Utilise ta classe personnalisée

class TypeElementRepository extends GenericRepository
{
    private \Doctrine\DBAL\Connection $connection; // Type Doctrine\DBAL\Connection pour la propriété

    public function __construct()
    {
        $this->connection = Connection::getConnection(); // Utilise ta méthode statique
    }
        
    /**
     * Trouve un type d'élément par son ID.
     *
     * @param int $id L'ID du type d'élément.
     * @return TypeElement|null Retourne le type d'élément ou null si non trouvé.
     */
    public function findById(int $id): ?TypeElement
    {
        $data = $this->connection->fetchAssociative(
            'SELECT * FROM TypeElement WHERE id = ?',
            [$id]
        );

        if (!$data) {
            return null;
        }

        $typeElement = new TypeElement();
        $typeElement->setId($data['id']);
        $typeElement->setLibelle($data['libelle']);
        $typeElement->setTraitement($data['traitement']);
        
        return $typeElement;
    }

    public function findAll(): array
    {
        $typeElementsData = $this->connection->fetchAllAssociative(
            'SELECT * FROM TypeElement ORDER BY libelle'
        );

        $typeElements = [];
        foreach ($typeElementsData as $data) {
            $typeElement = new TypeElement();
            $typeElement->setId($data['id']);
            $typeElement->setLibelle($data['libelle']);
            $typeElement->setTraitement($data['traitement']);
            $typeElements[] = $typeElement;
        }

        return $typeElements;
    }

    public function create(string $libelle, string $traitement): int
    {
        $this->connection->insert('TypeElement', [
            'libelle' => $libelle,
            'traitement' => $traitement
        ]);

        return (int) $this->connection->lastInsertId();
    }

    


    

    public function save(TypeElement $typeElement): int
    {
        $conn = Connection::getConnection();

        if ($typeElement->getId() === null) {
            // Insertion
            $sql = "INSERT INTO TypeElement (nom, traitement) VALUES (:nom, :traitement)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'nom' => $typeElement->getNom(),
                'traitement' => $typeElement->getTraitement()
            ]);
            $typeElement->setId($conn->lastInsertId());
        } else {
            // Mise à jour
            $sql = "UPDATE TypeElement SET nom = :nom, traitement = :traitement WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'nom' => $typeElement->getNom(),
                'traitement' => $typeElement->getTraitement(),
                'id' => $typeElement->getId()
            ]);
        }

        return $typeElement->getId();
    }

    

    
}
