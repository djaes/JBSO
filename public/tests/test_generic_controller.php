<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../vendor/autoload.php';

use JBSO\Controller\TypeElementPieceController;

try {
    $controller = new TypeElementPieceController();

    // Tester la liste des associations
    echo "<h2>Test du GenericController : Liste des Associations</h2>";
    $controller->list();

    echo "<form action='test_type_element_piece_controller.php' method='get'><button type='submit'>Tester le TypeElementPieceController</button></form>";
} catch (\Exception $e) {
    echo "<h2>Erreur dans le GenericController</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
