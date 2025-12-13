<?php
// src/Controller/TypeTacheController.php

namespace JBSO\Controller;

use JBSO\Repository\TypeTacheRepository;

class TypeTacheController extends GenericController
{
    public function __construct()
    {
        parent::__construct();
        $this->repository = new TypeTacheRepository();
    }

    protected function getEntityName(): string
    {
        return 'type-tache';
    }
    protected function getName(): string
    {
        return "Type de Tache";
    }
    protected function getTemplatePath(): string
    {
        return 'typeTache';
    }
}