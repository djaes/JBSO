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

    // Tester la récupération des types de pièces
    $typePieces = $repository->getAllTypePieces();
    echo "<h2>Test du TypeElementPieceRepository : Récupération des Types de Pièces</h2>";
    echo "<pre>";
    print_r($typePieces);
    echo "</pre>";

    // Tester la récupération des types d'éléments
    $typeElements = $repository->getAllTypeElements();
    echo "<h2>Test du TypeElementPieceRepository : Récupération des Types d'Éléments</h2>";
    echo "<pre>";
    print_r($typeElements);
    echo "</pre>";

    // Tester la récupération des types d'éléments pour un type de pièce
    if (!empty($typePieces)) {
        $typePieceId = $typePieces[0]['id'];
        $currentTypeElements = $repository->getTypeElementsByTypePiece($typePieceId);
        echo "<h2>Test du TypeElementPieceRepository : Récupération des Types d'Éléments pour le Type de Pièce $typePieceId</h2>";
        echo "<pre>";
        print_r($currentTypeElements);
        echo "</pre>";
    }

    echo "<form action='test_generic_controller.php' method='get'><button type='submit'>Tester le GenericController</button></form>";
} catch (\Exception $e) {
    echo "<h2>Erreur dans le TypeElementPieceRepository</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
