<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../vendor/autoload.php';

use JBSO\Controller\TypeElementPieceController;

try {
    $controller = new TypeElementPieceController();

    if (!empty($_GET['type_piece_id'])) {
        $typePieceId = $_GET['type_piece_id'];
        $typeElementIds = [1, 2, 3]; // Exemple de liste d'IDs de types d'éléments

        echo "<h2>Test de sauvegarde des Types d'Éléments pour le Type de Pièce $typePieceId</h2>";
        $controller->saveTypeElements($typePieceId, $typeElementIds);
        echo "<p>Types d'éléments sauvegardés avec succès.</p>";
    } else {
        echo "<p>Aucun type de pièce sélectionné.</p>";
    }

    echo "<form action='test_save_type_elements.php' method='get'>
            <label for='type_piece_id'>ID du Type de Pièce :</label>
            <input type='number' id='type_piece_id' name='type_piece_id' required>
            <button type='submit'>Tester la sauvegarde</button>
          </form>";
} catch (\Exception $e) {
    echo "<h2>Erreur lors de la sauvegarde des Types d'Éléments</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
