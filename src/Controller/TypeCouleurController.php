<?php
// src/Controller/TypeCouleurController.php

namespace JBSO\Controller;

use JBSO\Repository\TypeCouleurRepository;

class TypeCouleurController extends GenericController
{
    public function __construct()
    {
        parent::__construct();
        $this->repository = new TypeCouleurRepository();
    }

    protected function getEntityName(): string
    {
        return 'type-couleur';
    }
    protected function getName(): string
    {
        return "Type de Couleur";
    }
    protected function getTemplatePath(): string
    {
        return 'typeCouleur';
    }
}