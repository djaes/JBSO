<?php
// src/Controller/TypePieceController.php

namespace JBSO\Controller;

use JBSO\Repository\TypePieceRepository;

class TypePieceController extends GenericController
{
    public function __construct()
    {
        parent::__construct();
        $this->repository = new TypePieceRepository();
    }

    protected function getEntityName(): string
    {
        return 'type-piece';
    }
    protected function getName(): string
    {
        return "Type de Piece";
    }
    protected function getTemplatePath(): string
    {
        return 'typePiece';
    }
}