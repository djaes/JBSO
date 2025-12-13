<?php
// src/Controller/TypeFinitionController.php

namespace JBSO\Controller;

use JBSO\Repository\TypeFinitionRepository;

class TypeFinitionController extends GenericController
{
    public function __construct()
    {
        parent::__construct();
        $this->repository = new TypeFinitionRepository();
    }

    protected function getEntityName(): string
    {
        return 'type-finition';
    }
    protected function getName(): string
    {
        return "Type de Finition";
    }
    protected function getTemplatePath(): string
    {
        return 'typeFinition';
    }
}