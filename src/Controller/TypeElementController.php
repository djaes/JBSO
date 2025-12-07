<?php
// src/Controller/TypeElementController.php
namespace JBSO\Controller;


use JBSO\Repository\TypeElementRepository;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TypeElementController
{
    private Environment $twig;
    private TypeElementRepository $typeElementRepository;
    

    public function __construct()
    {
        // Configuration de Twig
        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        $this->twig = new Environment($loader);
        // Instanciation du Repository
        $this->typeElementRepository = new TypeElementRepository(); // Pas besoin de passer la connexion, elle est gérée dans le repository
    }
    
    public function show(int $id)
    {
        $typeElement = $this->typeElementRepository->findById($id);

        if (!$typeElement) {
            // Gérer le cas où le type d'élément n'existe pas
            throw new \RuntimeException("Type d'élément non trouvé.");
        }

        // Afficher les détails du type d'élément (ex : avec Twig)
        echo $this->twig->render('typeElement/show.html.twig', [
            'typeElement' => $typeElement,
        ]);
    }
    
    // Liste tous les types d'éléments
    public function list(): void
    {
        $typeElements = $this->typeElementRepository->findAll();
        echo $this->twig->render('typeElement/list.html.twig', [
            'typeElements' => $typeElements
        ]);
    }

    // Affiche le formulaire de création de type d'element
    public function showCreateForm(): void
    {
        echo $this->twig->render('typeElement/create.html.twig', [
            'message' => 'create.html',
        ]);
    }

    // Crée un nouveau type d'élément
    public function create(): void
    {
        $libelle = $_POST['libelle'] ?? '';
        $traitement = $_POST['traitement'] ?? '';

        if (empty($libelle) || empty($traitement)) {
            echo $this->twig->render('typeElement/create.html.twig', [
                'error' => 'Le libellé est obligatoire.'
            ]);
            return;
        }
        
        $id = $this->typeElementRepository->create($libelle, $traitement);
        header('Location: /type-element/'. $id);
    }

} 
?>