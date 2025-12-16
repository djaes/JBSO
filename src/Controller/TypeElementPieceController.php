<?php
// src/Controller/TypeElementPieceController.php
namespace JBSO\Controller;

use JBSO\Repository\TypeElementPieceRepository;

class TypeElementPieceController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
        $this->repository = new TypeElementPieceRepository();
    }

    protected function getEntityName(): string
    {
        return 'type-element-piece';
    }
    protected function getName(): string
    {
        return "Type d'élement par piece";
    }
    protected function getTemplatePath(): string
    {
        return 'typeElementPiece';
    }
    
    

    
}
