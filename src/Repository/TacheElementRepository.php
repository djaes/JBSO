<?php
// src/Repository/TacheElementRepository.php
namespace JBSO\Repository;

use JBSO\Entity\TacheElement;
use JBSO\Entity\Tache;
use JBSO\Entity\Element;
use Doctrine\DBAL\Connection;


class TacheElementRepository
{
    
    private $connection;

    // Constructeur pour injecter la connexion
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
    
        
    public function find(int $id): ?TacheElement
    {
        $data = $this->connection->fetchAssociative('
            SELECT te.*, t.id as tache_id, t.nom as tache_nom, e.id as element_id
            FROM TacheElement te
            JOIN Tache t ON te.tache_id = t.id
            JOIN Element e ON te.element_id = e.id
            WHERE te.id = ?', [$id]);

        if (!$data) {
            return null;
        }

        $tacheElement = new TacheElement();
        $tacheElement->setId($data['id']);
        $tacheElement->setOrdre($data['ordre']);
        $tacheElement->setStatut($data['statut']);

        $tache = new Tache();
        $tache->setId($data['tache_id']);
        $tache->setNom($data['tache_nom']);
        $tacheElement->setTache($tache);

        $element = new Element();
        $element->setId($data['element_id']);
        $tacheElement->setElement($element);

        return $tacheElement;
    }

    public function findAllByElementWithView(int $elementId): array
    {
       $tachesData = $this->connection->fetchAllAssociative('
            SELECT * FROM VueTachesElement
            WHERE element_id = ?
            ORDER BY ordre', [$elementId]);

        $taches = [];
        foreach ($tachesData as $data) {
            $tacheElement = new TacheElement();
            // Hydrate $tacheElement avec les données de $data
            $taches[] = $tacheElement;
        }
        return $taches;
    }


    // fonction tester et validé : renvoi toute les tache et leur statut by element id
    public function findAllTacheIdAndStatutByElement(int $elementId): array
    {
        $query = "
            SELECT id, statut
            FROM TacheElement
            WHERE element_id = ?
            ORDER BY ordre
        ";
        return $this->connection->fetchAllAssociative($query, [$elementId]);
    }   
    
    
    
    
    public function findAllByElement(int $elementId): array
    {
       return $this->connection->fetchAllAssociative(
            'SELECT * FROM TacheElement WHERE element_id = ? ORDER BY ordre',
            [$elementId]);
    }

    public function updateStatut(int $id, string $statut): void
    {
        $this->connection->executeStatement('CALL UpdateTacheStatut(?, ?)', [$id, $statut]);
    }

    public function canStartTache(int $tacheElementId): bool
    {
        $tache = $this->connection->fetchAssociative('
            SELECT element_id, ordre FROM TacheElement WHERE id = ?', [$tacheElementId]);
            
            $previousTachesNonTerminees = $this->connection->fetchOne('
            SELECT COUNT(*)
            FROM TacheElement
            WHERE element_id = ? AND ordre < ? AND statut != \'terminé\'', [
            $tache['element_id'],
            $tache['ordre']
        ]);

        return $previousTachesNonTerminees == 0;
    }
}
