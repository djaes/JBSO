<?php
// src/Controller/PieceChantierController.php
namespace JBSO\Controller;

use JBSO\Repository\PieceChantierController;

class PieceChantierController extends GenericController
{
    public function __construct()
    {
        parent::__construct();
        $this->repository = new PieceChantierController();
    }

    protected function getEntityName(): string
    {
        return 'piece_chantier';
    }

    protected function getName(): string
    {
        return "PieceChantier";
    }

    protected function getTemplatePath(): string
    {
        return 'pieceChantier';
    }
}
