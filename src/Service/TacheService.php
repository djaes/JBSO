<?php
namespace JBSO\Service;

use JBSO\Repository\TacheElementRepository;
use JBSO\Repository\ElementRepository;

class TacheService
{
    private TacheElementRepository $tacheElementRepository;
    private ElementRepository $elementRepository;

    public function __construct(
        TacheElementRepository $tacheElementRepository,
        ElementRepository $elementRepository
    ) {
        $this->tacheElementRepository = $tacheElementRepository;
        $this->elementRepository = $elementRepository;
    }

    public function startTache(int $tacheElementId): bool
    {
        if (!$this->tacheElementRepository->canStartTache($tacheElementId)) {
            return false;
        }
        $this->tacheElementRepository->updateStatut($tacheElementId, 'en cours');
        return true;
    }

    public function completeTache(int $tacheElementId): void
    {
        $this->tacheElementRepository->updateStatut($tacheElementId, 'terminé');
    }

    public function generateTachesForElement(int $elementId): void
    {
        $this->elementRepository->generateTachesForElement($elementId);
    }
}
