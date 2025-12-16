<?php
// src/Controller/TypeElementController.php

namespace JBSO\Controller;

use JBSO\Repository\TypeElementRepository;

class TypeElementController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
        $this->repository = new TypeElementRepository();
    }

    protected function getEntityName(): string
    {
        return 'type-element';
    }
    protected function getName(): string
    {
        return "type d'élement";
    }
    protected function getTemplatePath(): string
    {
        return 'typeElement';
    }
}
