<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../vendor/autoload.php';

use JBSO\Controller\TypeElementPieceController;

try {
    $controller = new TypeElementPieceController();

    if (!empty($_GET['type_piece_id']) && !empty($_GET['type_element_id'])) {
        $typePieceId = $_GET['type_piece_id'];
        $typeElementId = $_GET['type_element_id'];

        echo "<h2>Test de suppression d'une association entre le Type de Pièce $typePieceId et le Type d'Élément $typeElementId</h2>";
        $controller->delete($typePieceId, $typeElementId);
        echo "<p>Association supprimée avec succès.</p>";
    } else {
        echo "<p>Type de pièce ou type d'élément non sélectionné.</p>";
    }

    echo "<form action='test_delete_type_element_piece.php' method='get'>
            <label for='type_piece_id'>ID du Type de Pièce :</label>
            <input type='number' id='type_piece_id' name='type_piece_id' required>
            <label for='type_element_id'>ID du Type d'Élément :</label>
            <input type='number' id='type_element_id' name='type_element_id' required>
            <button type='submit'>Tester la suppression</button>
          </form>";
} catch (\Exception $e) {
    echo "<h2>Erreur lors de la suppression de l'association</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
