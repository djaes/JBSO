<?php
// src/Controller/TypeFinitionController.php

namespace JBSO\Controller;

use JBSO\Repository\TypeFinitionRepository;

class TypeFinitionController extends AbstractController
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
        return "type de finition";
    }
    protected function getTemplatePath(): string
    {
        return 'typeFinition';
    }
}