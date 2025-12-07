<?php
// src/Controller/TypeActionController.php
namespace JBSO\Controller;

use JBSO\Repository\TypeActionRepository;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TypeActionController
{
    private Environment $twig;
    private TypeActionRepository $typeActionRepository;

    public function __construct()
    {
        $this->typeActionRepository = new TypeActionRepository();
        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        $this->twig = new Environment($loader);
    }

    public function list(): void
    {
        $typeActions = $this->typeActionRepository->findAll();
        echo $this->twig->render('typeAction/list.html.twig', [
            'typeActions' => $typeActions
        ]);
    }

    public function show(int $id): void
    {
        $typeAction = $this->typeActionRepository->findById($id);
        if (!$typeAction) {
            throw new \RuntimeException("Type d'action non trouvé.");
        }

        echo $this->twig->render('typeAction/show.html.twig', [
            'typeAction' => $typeAction
        ]);
    }

    // Affiche le formulaire de création de type d'Action
    public function showCreateForm(): void
    {
        echo $this->twig->render('typeAction/create.html.twig', [
            'message' => 'create.html',
        ]);
    }
    // Crée un nouveau type Action
    public function create(): void
    {
        $libelle = $_POST['libelle'] ?? '';

        if (empty($libelle)) {
            echo $this->twig->render('typeAction/create.html.twig', [
                'error' => 'Le libellé est obligatoire.'
            ]);
            return;
        }
        
        $id = $this->typeElementRepository->create($libelle);
        header('Location: /type-action/'. $id);
    }

}
