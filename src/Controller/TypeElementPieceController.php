<?php
// src/Controller/TypeElementPieceController.php
namespace JBSO\Controller;

use JBSO\Repository\TypeElementPieceRepository;

class TypeElementPieceController extends GenericController
{
    public function __construct()
    {
        parent::__construct();
        $this->repository = new TypeElementPieceRepository();
    }

    pprotected function getEntityName(): string
    {
        return 'type-element-piece';
    }
    protected function getName(): string
    {
        return "Type de Element par piece";
    }
    protected function getTemplatePath(): string
    {
        return 'typeElementPiece';
    }

    
    public function manageTypeElements(int $id)
    {
        $typePiece = $this->repository->getTypePieceById($id);
        $typeElements = $this->repository->getAllTypeElements();
        $currentTypeElements = $this->repository->getTypeElementsByTypePiece($id);

        echo $this->twig->render("{$this->templatePath}/manage.html.twig", [
            'typePiece' => $typePiece,
            'typeElements' => $typeElements,
            'currentTypeElements' => $currentTypeElements,
            'entityName' => $this->entityName
        ]);
    }

    public function saveTypeElements(int $id)
    {
        $typeElementIds = $_POST['type_elements'] ?? [];
        $this->repository->saveTypeElementsForTypePiece($id, $typeElementIds);
        header("Location: /type-element-piece/$id/manage");
        exit;
    }

    
    
}
