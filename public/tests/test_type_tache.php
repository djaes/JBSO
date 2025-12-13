<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../debug.php';
require_once __DIR__ . '/fonction.php';

use JBSO\Database\Connection;

// Récupère l'étape actuelle (par défaut : 1)
$step = isset($_POST['step']) ? (int)$_POST['step'] : 1;
$lastId = isset($_POST['last_id']) ? (int)$_POST['last_id'] : 0;

// Affichage du titre
echo "<h1>Test : type tache</h1>";
backToIndexButton();
try {
    $conn = Connection::getConnection();
    logTest("Connexion à la base de données établie.");
} catch (\Exception $e) {
    logTest("Échec de la connexion à la base de données : " . $e->getMessage(), false);
    exit(1);
}

// Étape 1 : Création d'une Tache
if ($step == 1) {
    try {
        $sql = "INSERT INTO TypeTache (label) VALUES ('Test Tache')";
        $conn->executeStatement($sql);
        $lastId = $conn->lastInsertId();
        logTest("Création d'une Tache avec l'ID : $lastId");
        nextButton($step, $lastId);
    } catch (\Exception $e) {
        logTest("Échec de la création de la Tache : " . $e->getMessage(), false);
        nextButton($step);
    }
}

// Étape 2 : Listage des Taches
else if ($step == 2) {
    try {
        $sql = "SELECT * FROM TypeTache";
        $taches = $conn->fetchAllAssociative($sql);
        logTest("Listage des Type de Taches : " . count($taches) . " résultats.");
        foreach ($taches as $tache) {
            echo "<p>- ID: {$tache['id']}, label: {$tache['label']}</p>";
        }
        nextButton($step, $lastId);
    } catch (\Exception $e) {
        logTest("Échec du listage des Taches : " . $e->getMessage(), false);
        nextButton($step, $lastId);
    }
}

// Étape 3 : Suppression de la Tache créée
else if ($step == 3) {
    try {
        $sql = "DELETE FROM TypeTache WHERE id = ?";
        $conn->executeStatement($sql, [$lastId]);
        logTest("Suppression de la Tache avec l'ID : $lastId");
        nextButton($step, $lastId);
    } catch (\Exception $e) {
        logTest("Échec de la suppression de la Tache : " . $e->getMessage(), false);
        nextButton($step, $lastId);
    }
}

// Étape 4 : Vérification de la suppression
else if ($step == 4) {
    try {
        $sql = "SELECT COUNT(*) as count FROM TypeTache WHERE id = ?";
        $count = $conn->fetchOne($sql, [$lastId]);
        if ($count == 0) {
            logTest("Vérification : La Tache a bien été supprimée.");
        } else {
            logTest("Erreur : La Tache n'a pas été supprimée.", false);
        }
        echo "<p>Tous les tests sont terminés !</p>";
    } catch (\Exception $e) {
        logTest("Échec de la vérification de suppression : " . $e->getMessage(), false);
        echo "<p>Tous les tests sont terminés !</p>";
    }
}
