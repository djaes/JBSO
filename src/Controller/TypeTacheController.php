<?php
// src/Controller/TypeTacheController.php
namespace JBSO\Controller;

use JBSO\Repository\TypeTacheRepository;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TypeTacheController
{
    private Environment $twig;
    private TypeTacheRepository $typeTacheRepository;

    public function __construct()
    {
        $this->typeTacheRepository = new TypeTacheRepository();
        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        $this->twig = new Environment($loader);
    }

    public function list(): void
    {
        $typeTaches = $this->typeTacheRepository->findAll();
        echo $this->twig->render('typeTache/list.html.twig', [
            'typeTaches' => $typeTaches
        ]);
    }

    public function show(int $id): void
    {
        $typeTache = $this->typeTacheRepository->findById($id);
        if (!$typeTache) {
            throw new \RuntimeException("Type de tâche non trouvé.");
        }

        echo $this->twig->render('typeTache/show.html.twig', [
            'typeTache' => $typeTache
        ]);
    }

    // Affiche le formulaire de création de type de tache
    public function showCreateForm(): void
    {
        echo $this->twig->render('typeTache/create.html.twig', [
            'message' => 'create.html',
        ]);
    }
    // Crée un nouveau type de tache
    public function create(): void
    {
        $libelle = $_POST['libelle'] ?? '';
        $description = $_POST['description'] ?? '';

        if (empty($libelle) || empty($description)) {
            echo $this->twig->render('typeTache/create.html.twig', [
                'error' => 'Le libellé est obligatoire.'
            ]);
            return;
        }
        
        $id = $this->typeElementRepository->create($libelle, $description);
        header('Location: /type-tache/'. $id);
    }
}

