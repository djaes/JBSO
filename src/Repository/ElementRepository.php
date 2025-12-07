<?php
namespace JBSO\Repository;
// src/Repository/ElementRepository.php



use JBSO\Entity\Element;
use Doctrine\DBAL\Connection;

class ElementRepository
{
    
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
    
    /**
     * Trouve un élément par son ID.
     *
     * @param int $id L'ID de l'élément.
     * @return Element|null Retourne l'élément ou null si non trouvé.
     */
    public function findById(int $id): ?Element
    {
        $data = $this->connection->fetchAssociative(
            'SELECT * FROM Element WHERE id = ?',
            [$id]
        );

        if (!$data) {
            return null;
        }

        $element = new Element();
        $element->setId($data['id']);
        $element->setNom($data['nom']);
        $element->setTypeElementId($data['type_element_id']);
        $element->setPiece($data['piece']);
        $element->setDegreFinition($data['degre_finition']);
        $element->setCouleur($data['couleur']);
        // Ajoute d'autres setters si nécessaire

        return $element;
    }



    public function find(int $id): ?Element
    {
        $conn = Connection::getConnection();
        $data = $conn->fetchAssociative('
            SELECT e.*, te.id as type_element_id, te.nom as type_element_nom,
                   p.id as piece_id, p.nom as piece_nom,
                   df.id as degre_finition_id, df.libelle as degre_finition_libelle,
                   c.id as couleur_id, c.nom as couleur_nom
            FROM Element e
            JOIN TypeElement te ON e.type_element_id = te.id
            JOIN Piece p ON e.piece_id = p.id
            JOIN DegreFinition df ON e.degre_finition_id = df.id
            LEFT JOIN Couleur c ON e.couleur_id = c.id
            WHERE e.id = ?', [$id]);

        if (!$data) {
            return null;
        }

        $element = new Element();
        $element->setId($data['id']);
        $element->setNom($data['nom']);

        $typeElement = new TypeElement();
        $typeElement->setId($data['type_element_id']);
        $typeElement->setNom($data['type_element_nom']);
        $element->setTypeElement($typeElement);

        $piece = new Piece();
        $piece->setId($data['piece_id']);
        $piece->setNom($data['piece_nom']);
        $element->setPiece($piece);

        $degreFinition = new DegreFinition();
        $degreFinition->setId($data['degre_finition_id']);
        $degreFinition->setLibelle($data['degre_finition_libelle']);
        $element->setDegreFinition($degreFinition);

        if ($data['couleur_id']) {
            $couleur = new Couleur();
            $couleur->setId($data['couleur_id']);
            $couleur->setNom($data['couleur_nom']);
            $element->setCouleur($couleur);
        }

        return $element;
    }

    public function findAllByPiece(int $pieceId): array
    {
        $conn = Connection::getConnection();
        $elementsData = $conn->fetchAllAssociative('
            SELECT e.id, e.nom, te.id as type_element_id, te.nom as type_element_nom,
                   df.id as degre_finition_id, df.libelle as degre_finition_libelle,
                   c.id as couleur_id, c.nom as couleur_nom
            FROM Element e
            JOIN TypeElement te ON e.type_element_id = te.id
            JOIN DegreFinition df ON e.degre_finition_id = df.id
            LEFT JOIN Couleur c ON e.couleur_id = c.id
            WHERE e.piece_id = ?', [$pieceId]);

        $elements = [];
        foreach ($elementsData as $data) {
            $element = new Element();
            $element->setId($data['id']);
            $element->setNom($data['nom']);

            $typeElement = new TypeElement();
            $typeElement->setId($data['type_element_id']);
            $typeElement->setNom($data['type_element_nom']);
            $element->setTypeElement($typeElement);

            $degreFinition = new DegreFinition();
            $degreFinition->setId($data['degre_finition_id']);
            $degreFinition->setLibelle($data['degre_finition_libelle']);
            $element->setDegreFinition($degreFinition);

            if ($data['couleur_id']) {
                $couleur = new Couleur();
                $couleur->setId($data['couleur_id']);
                $couleur->setNom($data['couleur_nom']);
                $element->setCouleur($couleur);
            }

            $elements[] = $element;
        }
        return $elements;
    }

    public function save(Element $element): void
    {
        $conn = Connection::getConnection();
        if ($element->getId()) {
            // Mise à jour
            $conn->update('Element', [
                'nom' => $element->getNom(),
                'type_element_id' => $element->getTypeElement()->getId(),
                'piece_id' => $element->getPiece()->getId(),
                'degre_finition_id' => $element->getDegreFinition()->getId(),
                'couleur_id' => $element->getCouleur() ? $element->getCouleur()->getId() : null,
            ], ['id' => $element->getId()]);
        } else {
            // Insertion
            $conn->insert('Element', [
                'nom' => $element->getNom(),
                'type_element_id' => $element->getTypeElement()->getId(),
                'piece_id' => $element->getPiece()->getId(),
                'degre_finition_id' => $element->getDegreFinition()->getId(),
                'couleur_id' => $element->getCouleur() ? $element->getCouleur()->getId() : null,
            ]);
            $element->setId($conn->lastInsertId());
            // Appel de la procédure pour générer les tâches
            $conn->executeStatement('CALL GenerateTachesForElement(?)', [$element->getId()]);
        }
    }

    public function delete(int $id): void
    {
        $conn = Connection::getConnection();
        $conn->delete('Element', ['id' => $id]);
    }

    public function generateTachesForElement(int $elementId): void
    {
        // Appel à la procédure stockée
        $conn = Connection::getConnection();
        $conn->executeStatement('CALL GenerateTachesForElement(?)', [$elementId]);
    }

    public function create(array $data): void
    {
        $conn = Connection::getConnection();
        $conn->insert('Element', [
            'nom' => $data['nom'],
            'type_element_id' => $data['type_element_id'],
            'piece_id' => $data['piece_id'],
            'degre_finition_id' => $data['degre_finition_id'],
        ]);

        // Générer les tâches pour cet élément
        $elementId = $conn->lastInsertId();
        $conn->executeStatement('CALL GenerateTachesForElement(?)', [$elementId]);
    }

    public function createType(array $data): void
    {
        $conn = Connection::getConnection();
        $conn->insert('TypeElement', [
            'nom' => $data['nom'], ]);
    }

    public function update(int $id, array $data): void
    {
        $conn = Connection::getConnection();
        $conn->update('Element', [
            'nom' => $data['nom'],
            'type_element_id' => $data['type_element_id'],
            'piece_id' => $data['piece_id'],
            'degre_finition_id' => $data['degre_finition_id'],
        ], ['id' => $id]);
    }
}
