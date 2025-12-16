<?php
// src/Controller/TypeTacheElementTraitementController.php
namespace JBSO\Controller;

use JBSO\Repository\TypeTacheElementTraitementRepository;

class TypeTacheElementTraitementController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
        $this->repository = new TypeTacheElementTraitementRepository();
    }

    protected function getEntityName(): string
    {
        return 'type-tache-element-traitement';
    }
    protected function getName(): string
    {
        return "Type de tache par élement par traitement";
    }
    protected function getTemplatePath(): string
    {
        return 'typeTacheElementTraitement';
    }
    
    

    
}
