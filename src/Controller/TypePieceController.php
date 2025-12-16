<?php
// src/Controller/TypePieceController.php

namespace JBSO\Controller;

use JBSO\Repository\TypePieceRepository;

class TypePieceController extends AbstractController
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
        return "type de piece";
    }
    protected function getTemplatePath(): string
    {
        return 'typePiece';
    }
}