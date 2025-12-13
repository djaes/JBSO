<?php
// src/Controller/ChantierClientController.php
namespace JBSO\Controller;

use JBSO\Repository\ChantierClientRepository;

class ChantierClientController extends GenericController
{
    public function __construct()
    {
        parent::__construct();
        $this->repository = new ChantierClientRepository();
    }

    protected function getEntityName(): string
    {
        return 'chantier_client';
    }

    protected function getName(): string
    {
        return "Chantier";
    }

    protected function getTemplatePath(): string
    {
        return 'chantierClient';
    }
}
