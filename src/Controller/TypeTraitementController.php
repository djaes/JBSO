<?php
// src/Controller/TypeTraitementController.php

namespace JBSO\Controller;

use JBSO\Repository\TypeTraitementRepository;

class TypeTraitementController extends GenericController
{
    public function __construct()
    {
        parent::__construct();
        $this->repository = new TypeTraitementRepository();
    }

    protected function getEntityName(): string
    {
        return 'type-traitement';
    }

    protected function getTemplatePath(): string
    {
        return 'typeTraitement';
    }
    protected function getName(): string
    {
        return "Type d'Traitement ";
    }
}
