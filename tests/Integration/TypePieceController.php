<?php
// tests/Integration/TypePieceControllerTest.php
namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use JBSO\Repository\TypePieceRepository;
use JBSO\Controller\TypePieceController;

class TypePieceControllerTest extends TestCase
{
    public function testList()
    {
        // Créer une instance du repository
        $repository = new TypePieceRepository();

        // Créer une instance du contrôleur avec le repository
        $controller = new TypePieceController();

        // Utiliser la réflexion pour injecter le repository dans le contrôleur
        $reflection = new \ReflectionClass($controller);
        $property = $reflection->getProperty('repository');
        $property->setAccessible(true);
        $property->setValue($controller, $repository);

        // Appeler la méthode list du contrôleur
        ob_start();
        $controller->list();
        $output = ob_get_clean();

        // Vérifier que la sortie contient les données attendues
        $this->assertStringContainsString('Liste des Type de Piece', $output);
    }
}
