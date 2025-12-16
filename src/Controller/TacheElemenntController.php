<?php
// src/Controller/TacheElementController.php
namespace JBSO\Controller;

use JBSO\Repository\TacheElementController;

class TacheElementController extends GenericController
{
    public function __construct()
    {
        parent::__construct();
        $this->repository = new TypeElementController();
    }

    protected function getEntityName(): string
    {
        return 'tache_element';
    }

    protected function getName(): string
    {
        return "TacheElement";
    }

    protected function getTemplatePath(): string
    {
        return 'tacheElement';
    }
}
