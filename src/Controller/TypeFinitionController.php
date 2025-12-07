<?php
// src/Controller/TypeFinitionController.php
namespace JBSO\Controller;

use JBSO\Repository\TypeFinitionRepository;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TypeFinitionController
{
    private Environment $twig;
    private TypeFinitionRepository $typeFinitionRepository;

    public function __construct()
    {
        $this->typeFinitionRepository = new TypeFinitionRepository();
        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        $this->twig = new Environment($loader);
    }

    public function list(): void
    {
        $typeFinitions = $this->typeFinitionRepository->findAll();
        echo $this->twig->render('typeFinition/list.html.twig', [
            'typeFinitions' => $typeFinitions
        ]);
    }

    public function show(int $id): void
    {
        $typeFinition = $this->typeFinitionRepository->findById($id);
        if (!$typeFinition) {
            throw new \RuntimeException("Type de finition non trouvé.");
        }

        echo $this->twig->render('typeFinition/show.html.twig', [
            'typeFinition' => $typeFinition
        ]);
    }

    // Affiche le formulaire de création de type de  finition
    public function showCreateForm(): void
    {
        echo $this->twig->render('typeFinition/create.html.twig', [
            'message' => 'create.html',
        ]);
    }
    // Crée un nouveau type finition
    public function create(): void
    {
        $libelle = $_POST['libelle'] ?? '';

        if (empty($libelle)) {
            echo $this->twig->render('typeFinition/create.html.twig', [
                'error' => 'Le libellé est obligatoire.'
            ]);
            return;
        }
        
        $id = $this->typeElementRepository->create($libelle);
        header('Location: /type-finition/'. $id);
    }

}
