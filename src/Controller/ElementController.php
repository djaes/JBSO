<?php
// src/Controller/ElementController.php

namespace JBSO\Controller;


use JBSO\Repository\ElementRepository;
use JBSO\Repository\TypeElementRepository;
use JBSO\Repository\PieceRepository;
use JBSO\Repository\DegreFinitionRepository;
use JBSO\Database\Connection;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ElementController
{
    private Environment $twig;
    private ElementRepository $elementRepository;
    private TypeElementRepository $typeElementRepository;
    private PieceRepository $pieceRepository;
    private DegreFinitionRepository $degreFinitionRepository;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        $this->twig = new Environment($loader);
        $this->elementRepository = new ElementRepository();
        
    }

    public function showTest(): void
    {
        echo $this->twig->render('test/test.html.twig', [
            'message' => 'Test Twig',
        ]);
    }

    public function showHome(): void
    {
        echo $this->twig->render('showHome.html.twig', [
            'message' => 'Accueil',
        ]);
    }
    
    // Affiche le formulaire de création d'element
    public function showCreateForm(): void
    {
        echo $this->twig->render('element/create.html.twig', [
            'message' => 'create.html',
        ]);
    }
    // Affiche le formulaire de création de type d'element
    public function showCreateTypeForm(): void
    {
        echo $this->twig->render('element/createType.html.twig', [
            'message' => 'createType.html',
        ]);
    }
    // Crée un nouvel élément
    public function create(): void
    {
        // Récupère les données du formulaire
        $data = [
            'nom' => $_POST['nom'] ?? '',
            'type_element_id' => (int)($_POST['type_element_id'] ?? 0),
            'piece_id' => (int)($_POST['piece_id'] ?? 0),
            'degre_finition_id' => (int)($_POST['degre_finition_id'] ?? 0),
        ];

        // Valide et crée l'élément (à implémenter dans ElementRepository)
        $this->elementRepository->create($data);

        header('Location: /');
    }

    // Crée un nouveau type d'élément
    public function createTypeElement(): void
    {
        $nom = $_POST['nom'] ?? '';

        if (!empty($nom)) {
            try {
                $conn = Connection::getConnection();
                $conn->insert('TypeElement', ['nom' => $nom]);
                header('Location: /element/createType?success=1');
            } catch (\Exception $e) {
                header('Location: /element/createType?error=db&message=' . urlencode($e->getMessage()));
            }
            exit;
        } else {
            header('Location: /element/createType?error=1');
            exit;
        }
    }

}
?>
