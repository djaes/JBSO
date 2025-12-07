<?php
// src/Repository/PieceRepository.php

namespace JBSO\Repository;

use JBSO\Database\Connection;
use JBSO\Entity\Piece;

class PieceRepository
{
    public function find(int $id): ?Piece
    {
        $conn = Connection::getConnection();
        $data = $conn->fetchAssociative('SELECT * FROM Piece WHERE id = ?', [$id]);

        if (!$data) {
            return null;
        }

        $piece = new Piece();
        $piece->setId($data['id']);
        $piece->setNom($data['nom']);
        $piece->setEtage($data['etage']);
        $piece->setTypePieceId($data['type_piece_id']);
        $piece->setChantierId($data['chantier_id']);

        return $piece;
    }

    public function findAll(): array
    {
        $conn = Connection::getConnection();
        $piecesData = $conn->fetchAllAssociative('SELECT * FROM Piece ORDER BY nom');

        $pieces = [];
        foreach ($piecesData as $data) {
            $piece = new Piece();
            $piece->setId($data['id']);
            $piece->setNom($data['nom']);
            $piece->setEtage($data['etage']);
            $piece->setTypePieceId($data['type_piece_id']);
            $piece->setChantierId($data['chantier_id']);
            $pieces[] = $piece;
        }

        return $pieces;
    }
}
