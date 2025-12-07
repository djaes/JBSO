<?php

// Fonction pour afficher un message de test
function logTest($message, $success = true) {
    echo "<p style='color: ".($success ? "green" : "red").";'>[".($success ? "SUCCESS" : "ERROR")."] $message</p>";
}

// Fonction pour afficher le bouton "Suivant"
function nextButton($step, $lastId = 0) {
    echo '<form method="post" style="margin: 15px 0;">';
    echo '<input type="hidden" name="step" value="'.($step + 1).'">';
    echo '<input type="hidden" name="last_id" value="'.$lastId.'">';
    echo '<button type="submit" style="padding: 8px 15px; background: #4CAF50; color: white; border: none; cursor: pointer;">Suivant →</button>';
    echo '</form>';
}

// Fonction pour afficher le bouton "Retour à l'index"
function backToIndexButton() {
    echo '<div style="margin: 20px 0;">';
    echo '<a href="index.php" style="padding: 8px 15px; background: #f44336; color: white; text-decoration: none;">← Retour à l\'index</a>';
    echo '</div>';
}

?>