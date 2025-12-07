<?php
// src/Controller/TypeCouleurController.php
namespace JBSO\Controller;

use JBSO\Repository\TypeCouleurRepository;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TypeCouleurController
{
    private Environment $twig;
    private TypeCouleurRepository $typeCouleurRepository;

    public function __construct()
    {
        $this->typeCouleurRepository = new TypeCouleurRepository();
        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        $this->twig = new Environment($loader);
    }

    public function list(): void
    {
        $typeCouleurs = $this->typeCouleurRepository->findAll();
        echo $this->twig->render('typeCouleur/list.html.twig', [
            'typeCouleurs' => $typeCouleurs
        ]);
    }

    public function show(int $id): void
    {
        $typeCouleur = $this->typeCouleurRepository->findById($id);
        if (!$typeCouleur) {
            throw new \RuntimeException("Type de couleur non trouvé.");
        }

        echo $this->twig->render('typeCouleur/show.html.twig', [
            'typeCouleur' => $typeCouleur
        ]);
    }

    // Affiche le formulaire de création de type de couleur
    public function showCreateForm(): void
    {
        echo $this->twig->render('typeCouleur/create.html.twig', [
            'message' => 'create.html',
        ]);
    }
    // Crée un nouveau type Action
    public function create(): void
    {
        $libelle = $_POST['libelle'] ?? '';

        if (empty($libelle)) {
            echo $this->twig->render('typeCouleur/create.html.twig', [
                'error' => 'Le libellé est obligatoire.'
            ]);
            return;
        }
        
        $id = $this->typeElementRepository->create($libelle);
        header('Location: /type-couleur/'. $id);
    }

}
