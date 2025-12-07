<?php
namespace JBSO\Repository;

use JBSO\Database\Connection;
use JBSO\Entity\TacheTypeElementDegreFinition;
use JBSO\Entity\Tache;
use JBSO\Entity\TypeElement;
use JBSO\Entity\DegreFinition;

class TacheTypeElementDegreFinitionRepository
{
    public function findAllByTypeElementAndDegreFinition(int $typeElementId, int $degreFinitionId): array
    {
        $conn = Connection::getConnection();
        $data = $conn->fetchAllAssociative('
            SELECT ttedf.*, t.id as tache_id, t.nom as tache_nom, t.description as tache_description
            FROM TacheTypeElementDegreFinition ttedf
            JOIN Tache t ON ttedf.tache_id = t.id
            WHERE ttedf.type_element_id = ? AND ttedf.degre_finition_id = ?
            ORDER BY ttedf.ordre', [$typeElementId, $degreFinitionId]);

        $tachesTypes = [];
        foreach ($data as $row) {
            $tacheType = new TacheTypeElementDegreFinition();
            $tacheType->setId($row['id']);
            $tacheType->setOrdre($row['ordre']);

            $tache = new Tache();
            $tache->setId($row['tache_id']);
            $tache->setNom($row['tache_nom']);
            $tache->setDescription($row['tache_description']);
            $tacheType->setTache($tache);

            $typeElement = new TypeElement();
            $typeElement->setId($typeElementId);
            $tacheType->setTypeElement($typeElement);

            $degreFinition = new DegreFinition();
            $degreFinition->setId($degreFinitionId);
            $tacheType->setDegreFinition($degreFinition);

            $tachesTypes[] = $tacheType;
        }
        return $tachesTypes;
    }

    public function save(TacheTypeElementDegreFinition $tacheType): void
    {
        $conn = Connection::getConnection();
        if ($tacheType->getId()) {
            $conn->update('TacheTypeElementDegreFinition', [
                'tache_id' => $tacheType->getTache()->getId(),
                'ordre' => $tacheType->getOrdre(),
            ], ['id' => $tacheType->getId()]);
        } else {
            $conn->insert('TacheTypeElementDegreFinition', [
                'type_element_id' => $tacheType->getTypeElement()->getId(),
                'degre_finition_id' => $tacheType->getDegreFinition()->getId(),
                'tache_id' => $tacheType->getTache()->getId(),
                'ordre' => $tacheType->getOrdre(),
            ]);
            $tacheType->setId($conn->lastInsertId());
        }
    }
}
