<?php
// src/Controller/ElementPieceController.php
namespace JBSO\Controller;

use JBSO\Repository\ElementPieceController;

class ElementPieceController extends GenericController
{
    public function __construct()
    {
        parent::__construct();
        $this->repository = new ElementPiecerController();
    }

    protected function getEntityName(): string
    {
        return 'element_piece';
    }

    protected function getName(): string
    {
        return "ElementPiece";
    }

    protected function getTemplatePath(): string
    {
        return 'elementPiece';
    }
}
