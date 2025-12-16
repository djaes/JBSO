<?php
// src/Controller/ClientController.php
namespace JBSO\Controller;

use JBSO\Repository\ClientRepository;

class ClientController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
        $this->repository = new ClientRepository();
    }

    protected function getEntityName(): string
    {
        return 'client';
    }
    protected function getName(): string
    {
        return "Client";
    }
    protected function getTemplatePath(): string
    {
        return 'client';
    }
}