<?php
// src/Controller/GenericController.php

namespace JBSO\Controller;

use JBSO\Repository\GenericRepository;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class GenericController
{
    protected Environment $twig;
    protected GenericRepository $repository;
    protected string $entityName;
    protected string $templatePath;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        $this->twig = new Environment($loader);
    }

    abstract protected function getEntityName(): string;
    abstract protected function getTemplatePath(): string;

    public function list()
    {
        $entities = $this->repository->findAll();
        

        echo $this->twig->render('generic/list.html.twig', [
            'entities' => $entities,
            'entityName' => $this->getEntityName(),
            'template' => $this->getTemplatePath()
        ]);
        
    }

    public function show(int $id)
    {
        $entity = $this->repository->findById($id);
        if (!$entity) {
            throw new \RuntimeException("Entité non trouvée.");
        }

        echo $this->twig->render("generic/show.html.twig", [
            'entity' => $entity,
            'entityName' => $this->getEntityName(),
            'template' => $this->getTemplatePath()
        ]);
    }

    public function showCreateForm()
    {
        echo $this->twig->render("generic/create.html.twig", [
            'entityName' => $this->getEntityName(),
            'template' => $this->getTemplatePath()
        ]);
    }

    public function create()
    {
        $data = $_POST;

        // Vérifie que les données nécessaires sont présentes
        if (empty($data['libelle'])) {
            echo $this->twig->render('generic/create.html.twig', [
                'error' => 'Le libellé est obligatoire.',
                'entityName' => $this->getEntityName()
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
        $entity = $this->repository->findById($id);
        if (!$entity) {
            throw new \RuntimeException("Entité non trouvée.");
        }

        echo $this->twig->render("generic/update.html.twig", [
            'entity' => $entity,
            'entityName' => $this->getEntityName(),
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
                'template' => $this->getTemplatePath()
            ]);
        }
    }

    public function delete(int $id)
    {
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
