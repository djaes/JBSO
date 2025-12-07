<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../debug.php';
require_once __DIR__ . '/fonction.php';

use JBSO\Database\Connection;

// Récupère l'étape actuelle (par défaut : 1)
$step = isset($_POST['step']) ? (int)$_POST['step'] : 1;
$lastId = isset($_POST['last_id']) ? (int)$_POST['last_id'] : 0;



// Affichage du titre
echo "<h1>Test : DegreFinition</h1>";
backToIndexButton();
try {
    $conn = Connection::getConnection();
    logTest("Connexion à la base de données établie.");
} catch (\Exception $e) {
    logTest("Échec de la connexion à la base de données : " . $e->getMessage(), false);
    exit(1);
}

// Étape 1 : Création d'un TypeAction
if ($step == 1) {
    try {
        $sql = "INSERT INTO TypeAction (nom) VALUES ('Test TypeAction')";
        $conn->executeStatement($sql);
        $lastId = $conn->lastInsertId();
        logTest("Création d'un TypeAction avec l'ID : $lastId");
        nextButton($step, $lastId);
    } catch (\Exception $e) {
        logTest("Échec de la création du TypeAction : " . $e->getMessage(), false);
        nextButton($step);
    }
}

// Étape 2 : Listage des TypeAction
else if ($step == 2) {
    try {
        $sql = "SELECT * FROM TypeAction";
        $types = $conn->fetchAllAssociative($sql);
        logTest("Listage des TypeAction : " . count($types) . " résultats.");
        foreach ($types as $type) {
            echo "<p>- ID: {$type['id']}, Nom: {$type['nom']}</p>";
        }
        nextButton($step, $lastId);
    } catch (\Exception $e) {
        logTest("Échec du listage des TypeAction : " . $e->getMessage(), false);
        nextButton($step, $lastId);
    }
}

// Étape 3 : Suppression du TypeAction créé
else if ($step == 3) {
    try {
        $sql = "DELETE FROM TypeAction WHERE id = ?";
        $conn->executeStatement($sql, [$lastId]);
        logTest("Suppression du TypeAction avec l'ID : $lastId");
        nextButton($step, $lastId);
    } catch (\Exception $e) {
        logTest("Échec de la suppression du TypeAction : " . $e->getMessage(), false);
        nextButton($step, $lastId);
    }
}

// Étape 4 : Vérification de la suppression
else if ($step == 4) {
    try {
        $sql = "SELECT COUNT(*) as count FROM TypeAction WHERE id = ?";
        $count = $conn->fetchOne($sql, [$lastId]);
        if ($count == 0) {
            logTest("Vérification : Le TypeAction a bien été supprimé.");
        } else {
            logTest("Erreur : Le TypeAction n'a pas été supprimé.", false);
        }
        echo "<p>Tous les tests sont terminés !</p>";
    } catch (\Exception $e) {
        logTest("Échec de la vérification de suppression : " . $e->getMessage(), false);
        echo "<p>Tous les tests sont terminés !</p>";
    }
}
