<?php
// src/Controller/TypePieceController.php
namespace JBSO\Controller;

use JBSO\Repository\TypePieceRepository;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TypePieceController
{
    private Environment $twig;
    private TypePieceRepository $typePieceRepository;

    public function __construct()
    {
        $this->typePieceRepository = new TypePieceRepository();
        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        $this->twig = new Environment($loader);
    }

    public function list(): void
    {
        $typePieces = $this->typePieceRepository->findAll();
        echo $this->twig->render('typePiece/list.html.twig', [
            'typePieces' => $typePieces
        ]);
    }

    public function show(int $id): void
    {
        $typePiece = $this->typePieceRepository->findById($id);
        if (!$typePiece) {
            throw new \RuntimeException("Type de pièce non trouvé.");
        }

        echo $this->twig->render('typePiece/show.html.twig', [
            'typePiece' => $typePiece
        ]);
    }

    // Affiche le formulaire de création de type dde piece
    public function showCreateForm(): void
    {
        echo $this->twig->render('typePiece/create.html.twig', [
            'message' => 'create.html',
        ]);
    }
    // Crée un nouveau type de piece
    public function create(): void
    {
        $libelle = $_POST['libelle'] ?? '';
        
        if (empty($libelle)) {
            echo $this->twig->render('typePiece/create.html.twig', [
                'error' => 'Le libellé est obligatoire.'
            ]);
            return;
        }
        
        $id = $this->typeElementRepository->create($libelle);
        header('Location: /type-piece/'. $id);
    }

}
