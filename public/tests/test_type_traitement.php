<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../debug.php';
require_once __DIR__ . '/fonction.php';

use JBSO\Database\Connection;

// Récupère l'étape actuelle (par défaut : 1)
$step = isset($_POST['step']) ? (int)$_POST['step'] : 1;
$lastId = isset($_POST['last_id']) ? (int)$_POST['last_id'] : 0;



// Affichage du titre
echo "<h1>Test : type de traitement</h1>";
backToIndexButton();
try {
    $conn = Connection::getConnection();
    logTest("Connexion à la base de données établie.");
} catch (\Exception $e) {
    logTest("Échec de la connexion à la base de données : " . $e->getMessage(), false);
    exit(1);
}

// Étape 1 : Création d'un TypeTraitement
if ($step == 1) {
    try {
        $sql = "INSERT INTO TypeTraitement (label) VALUES ('à tester')";
        $conn->executeStatement($sql);
        $lastId = $conn->lastInsertId();
        logTest("Création d'un TypeTraitement avec l'ID : $lastId");
        nextButton($step, $lastId);
    } catch (\Exception $e) {
        logTest("Échec de la création du TypeTraitement : " . $e->getMessage(), false);
        nextButton($step);
    }
}

// Étape 2 : Listage des TypeTraitement
else if ($step == 2) {
    try {
        $sql = "SELECT * FROM TypeTraitement";
        $types = $conn->fetchAllAssociative($sql);
        logTest("Listage des TypeTraitement : " . count($types) . " résultats.");
        foreach ($types as $type) {
            echo "<p>- ID: {$type['id']}, Label: {$type['label']}</p>";
        }
        nextButton($step, $lastId);
    } catch (\Exception $e) {
        logTest("Échec du listage des TypeTraitement : " . $e->getMessage(), false);
        nextButton($step, $lastId);
    }
}

// Étape 3 : Suppression du TypeTraitement créé
else if ($step == 3) {
    try {
        $sql = "DELETE FROM TypeTraitement WHERE id = ?";
        $conn->executeStatement($sql, [$lastId]);
        logTest("Suppression du TypeTraitement avec l'ID : $lastId");
        nextButton($step, $lastId);
    } catch (\Exception $e) {
        logTest("Échec de la suppression du TypeTraitement : " . $e->getMessage(), false);
        nextButton($step, $lastId);
    }
}

// Étape 4 : Vérification de la suppression
else if ($step == 4) {
    try {
        $sql = "SELECT COUNT(*) as count FROM TypeTraitement WHERE id = ?";
        $count = $conn->fetchOne($sql, [$lastId]);
        if ($count == 0) {
            logTest("Vérification : Le TypeTraitement a bien été supprimé.");
        } else {
            logTest("Erreur : Le TypeTraitement n'a pas été supprimé.", false);
        }
        echo "<p>Tous les tests sont terminés !</p>";
    } catch (\Exception $e) {
        logTest("Échec de la vérification de suppression : " . $e->getMessage(), false);
        echo "<p>Tous les tests sont terminés !</p>";
    }
}
