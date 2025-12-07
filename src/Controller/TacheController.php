<?php
// src/Controller/TacheController.php
namespace JBSO\Controller;

use JBSO\Repository\TacheElementRepository;
use Doctrine\DBAL\Connection;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TacheController
{
    private Environment $twig;
    private TacheElementRepository $tacheRepository; // Déclaration de la propriété
    
    public function __construct(Connection $connection)
    {
        $this->tacheRepository = new TacheElementRepository($connection);
                
        // Configuration de Twig
        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        $this->twig = new Environment($loader);
    }

    // Liste les tâches d'un élément
    // src/Controller/TacheController.php
    public function listByElement(int $elementId): void
    {
        $taches = $this->tacheRepository->findAllTacheIdAndStatutByElement($elementId);
        echo $this->twig->render('tache/list.html.twig', [
            'taches' => $taches,
            'elementId' => $elementId
        ]);
    }

    

    // Démarre une tâche
    public function startTache(int $tacheId): void
{
    // Vérifie si la tâche peut être démarrée
    if ($this->tacheRepository->canStartTache($tacheId)) {
        $this->tacheRepository->updateStatut($tacheId, 'en cours');
    }

    // Récupère l'ID de l'élément associé à la tâche
    $elementId = $this->tacheRepository->findById($tacheId)->getElement()->getId();

    // Redirige vers la liste des tâches de l'élément
    header("Location: /tache/list/$elementId");
    exit();
}

    // Termine une tâche
    public function finishTache(int $tacheElementId): void
    {
        $this->tacheRepository->updateStatut($tacheElementId, 'terminé');
        $elementId = $this->tacheRepository->find($tacheElementId)->getElement()->getId();
        header('Location: /tache/list/' . $elementId);
    }
}
