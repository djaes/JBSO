<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../debug.php';
require_once __DIR__ . '/fonction.php';

use JBSO\Database\Connection;

// Récupère l'étape actuelle (par défaut : 1)
$step = isset($_POST['step']) ? (int)$_POST['step'] : 1;
$lastId = isset($_POST['last_id']) ? (int)$_POST['last_id'] : 0;



// Affichage du titre
echo "<h1>Test : Finition</h1>";
backToIndexButton();


try {
    $conn = Connection::getConnection();
    logTest("Connexion à la base de données établie.");
} catch (\Exception $e) {
    logTest("Échec de la connexion à la base de données : " . $e->getMessage(), false);
    exit(1);
}

// Étape 1 : Création d'un DegreFinition
if ($step == 1) {
    try {
        $sql = "INSERT INTO TypeFinition (label) VALUES ('test_finition')";
        $conn->executeStatement($sql);
        $lastId = $conn->lastInsertId();
        logTest("Création d'un DegreFinition avec l'ID : $lastId");
        nextButton($step, $lastId);
    } catch (\Exception $e) {
        logTest("Échec de la création du DegreFinition : " . $e->getMessage(), false);
        nextButton($step);
    }
}

// Étape 2 : Listage des DegreFinition
else if ($step == 2) {
    try {
        $sql = "SELECT * FROM TypeFinition";
        $degres = $conn->fetchAllAssociative($sql);
        logTest("Listage des TypeFinition : " . count($degres) . " résultats.");
        foreach ($degres as $degre) {
            echo "<p>- ID: {$degre['id']}, Label: {$degre['label']}</p>";
        }
        nextButton($step, $lastId);
    } catch (\Exception $e) {
        logTest("Échec du listage des DegreFinition : " . $e->getMessage(), false);
        nextButton($step, $lastId);
    }
}

// Étape 3 : Suppression du DegreFinition créé
else if ($step == 3) {
    try {
        $sql = "DELETE FROM TypeFinition WHERE id = ?";
        $conn->executeStatement($sql, [$lastId]);
        logTest("Suppression du TypeFinition avec l'ID : $lastId");
        nextButton($step, $lastId);
    } catch (\Exception $e) {
        logTest("Échec de la suppression du TypeFinition : " . $e->getMessage(), false);
        nextButton($step, $lastId);
    }
}

// Étape 4 : Vérification de la suppression
else if ($step == 4) {
    try {
        $sql = "SELECT COUNT(*) as count FROM TypeFinition WHERE id = ?";
        $count = $conn->fetchOne($sql, [$lastId]);
        if ($count == 0) {
            logTest("Vérification : Le TypeFinition a bien été supprimé.");
        } else {
            logTest("Erreur : Le TypeFinition n'a pas été supprimé.", false);
        }
        nextButton($step, $lastId);
    } catch (\Exception $e) {
        logTest("Échec de la vérification de suppression : " . $e->getMessage(), false);
        nextButton($step, $lastId);
    }
}
// Étape 5 : Listage des TypeFinition
else if ($step == 5) {
    try {
        $sql = "SELECT * FROM TypeFinition";
        $degres = $conn->fetchAllAssociative($sql);
        logTest("Listage des TypeFinition apres supression: " . count($degres) . " résultats.");
        foreach ($degres as $degre) {
            echo "<p>- ID: {$degre['id']}, Label: {$degre['label']}</p>";
        }
        nextButton($step, $lastId);
    } catch (\Exception $e) {
        logTest("Échec du listage des TypeFinition : " . $e->getMessage(), false);
        nextButton($step, $lastId);
    }
}

// Étape 5 : Test de suppression d'un ID inexistant
else if ($step == 6) {
    try {
        $sql = "DELETE FROM TypeFinition WHERE id = -1";
        $conn->executeStatement($sql);
        logTest("Test de suppression d'un ID inexistant : OK (pas d'erreur levée).");
        echo "<p>Tous les tests sont terminés !</p>";
    } catch (\Exception $e) {
        logTest("Erreur inattendue lors de la suppression d'un ID inexistant : " . $e->getMessage(), false);
        echo "<p>Tous les tests sont terminés !</p>";
    }
}
