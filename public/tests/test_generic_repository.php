<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../vendor/autoload.php';

use JBSO\Repository\TypeElementPieceRepository;

try {
    $repository = new TypeElementPieceRepository();

    // Tester la récupération de toutes les associations
    $typeElementPieces = $repository->getAllTypeElementPieces();
    echo "<h2>Test du TypeElementPieceRepository : Récupération de toutes les associations</h2>";
    echo "<pre>";
    print_r($typeElementPieces);
    echo "</pre>";

    echo "<form action='test_type_element_piece_repository.php' method='get'><button type='submit'>Tester le TypeElementPieceRepository</button></form>";
} catch (\Exception $e) {
    echo "<h2>Erreur dans le TypeElementPieceRepository</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
