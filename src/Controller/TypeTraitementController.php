<?php
// src/Controller/TypeTraitementController.php

namespace JBSO\Controller;

use JBSO\Repository\TypeTraitementRepository;

class TypeTraitementController extends AbstractController
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
    protected function getName(): string
    {
        return "type de traitement ";
    }
    protected function getTemplatePath(): string
    {
        return 'typeTraitement';
    }
    
}
