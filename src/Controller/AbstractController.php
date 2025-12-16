<?php
// src/Controller/AbstractController.php

namespace JBSO\Controller;

use JBSO\Repository\AbstractRepositoryInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController implements AbstractControllerInterface
{
    protected Environment $twig;
    protected AbstractRepositoryInterface $repository;
    protected string $entityName;
    protected string $templatePath;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        $this->twig = new Environment($loader);
        
    }

    abstract protected function getEntityName(): string;
    abstract protected function getTemplatePath(): string;
    abstract protected function getName(): string;

    public function list()
    {
        $entities = $this->repository->findAll();        
        $templatePath = $this->getTemplatePath();
        echo $this->twig->render("{$this->getTemplatePath()}/list.html.twig", [
            'entities' => $entities,
            'entityName' => $this->getEntityName(),
            'name' => $this->getName()
        ]);
        
    }

    public function show(int $id)
    {
        $entity = $this->repository->findById($id);
        $templatePath = $this->getTemplatePath();
        if (!$entity) {
            throw new \RuntimeException("Entité non trouvée.");
        }

        echo $this->twig->render("{$this->getTemplatePath()}/show.html.twig", [
            'entity' => $entity,
            'entityName' => $this->getEntityName(),
            'name' => $this->getName(),
            'template' => $this->getTemplatePath()
        ]);
    }

    public function showCreateForm()
    {
        $templatePath = $this->getTemplatePath();
        echo $this->twig->render("{$this->getTemplatePath()}/create.html.twig", [
            'entityName' => $this->getEntityName(),
            'name' => $this->getName(),
            'template' => $this->getTemplatePath()
        ]);
    }

    public function create()
    {
        $templatePath = $this->getTemplatePath();
        $data = $_POST;
        // Vérifie que les données nécessaires sont présentes
        // Le libellé est requis : si absent ou vide, afficher l'erreur
        if (empty($data['label']) || trim((string)$data["label"]) === '') {
            echo $this->twig->render("{$this->getTemplatePath()}/create.html.twig", [
                'error' => 'Le libellé est obligatoire.',
                'entityName' => $this->getEntityName(),
                'name' => $this->getName()
            ]);
            return;
        }

        // Crée l'entité
        $id = $this->repository->create($data);

        // Redirige vers la page de détails de la nouvelle entité
        header("Location: /{$this->getEntityName()}/{$id}");
        exit;
    }


    public function showUpdateForm(int $id)
    {
        $templatePath = $this->getTemplatePath();
        $entity = $this->repository->findById($id);
        if (!$entity) {
            throw new \RuntimeException("Entité non trouvée.");
        }

        echo $this->twig->render("{$this->getTemplatePath()}/update.html.twig", [
            'entity' => $entity,
            'entityName' => $this->getEntityName(),
            'name' => $this->getName(),
            'template' => $this->getTemplatePath()
        ]);
    }

    public function update(int $id)
    {
        $data = $_POST;
        $success = $this->repository->update($id, $data);

        if ($success) {
            header("Location: /{$this->getEntityName()}/{$id}");
            
        } else {
            echo $this->twig->render("{$this->getTemplatePath()}/update.html.twig", [
                'entity' => $this->repository->findById($id),
                'error' => 'Impossible de mettre à jour l\'entité.',
                'entityName' => $this->getEntityName(),
                'name' => $this->getName(),
                'template' => $this->getTemplatePath()
            ]);
        }
    }

    public function delete(int $id)
    {
        $templatePath = $this->getTemplatePath();
        $success = $this->repository->delete($id);

        if ($success) {
            header("Location: /{$this->getEntityName()}");
        } else {
            echo $this->twig->render("{$this->getTemplatePath()}/show.html.twig", [
                'entity' => $this->repository->findById($id),
                'error' => 'Impossible de supprimer l\'entité.',
                'entityName' => $this->getEntityName()
            ]);
        }
    }
}
