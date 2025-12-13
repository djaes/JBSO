<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../vendor/autoload.php';

use JBSO\Controller\TypeElementPieceController;

try {
    $controller = new TypeElementPieceController();

    // Tester la gestion des types d'éléments pour un type de pièce
    if (!empty($_GET['type_piece_id'])) {
        $typePieceId = $_GET['type_piece_id'];
        echo "<h2>Test du TypeElementPieceController : Gestion des Types d'Éléments pour le Type de Pièce $typePieceId</h2>";
        $controller->manageTypeElements($typePieceId);
    } else {
        echo "<p>Aucun type de pièce sélectionné.</p>";
    }

    echo "<form action='test_type_element_piece_controller.php' method='get'>
            <label for='type_piece_id'>ID du Type de Pièce :</label>
            <input type='number' id='type_piece_id' name='type_piece_id' required>
            <button type='submit'>Tester avec cet ID</button>
          </form>";
} catch (\Exception $e) {
    echo "<h2>Erreur dans le TypeElementPieceController</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
