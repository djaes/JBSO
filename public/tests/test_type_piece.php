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

// Étape 1 : Création d'un TypePiece
if ($step == 1) {
    try {
        $sql = "INSERT INTO TypePiece (nom) VALUES ('Test TypePiece')";
        $conn->executeStatement($sql);
        $lastId = $conn->lastInsertId();
        logTest("Création d'un TypePiece avec l'ID : $lastId");
        nextButton($step, $lastId);
    } catch (\Exception $e) {
        logTest("Échec de la création du TypePiece : " . $e->getMessage(), false);
        nextButton($step);
    }
}

// Étape 2 : Listage des TypePiece
else if ($step == 2) {
    try {
        $sql = "SELECT * FROM TypePiece";
        $types = $conn->fetchAllAssociative($sql);
        logTest("Listage des TypePiece : " . count($types) . " résultats.");
        foreach ($types as $type) {
            echo "<p>- ID: {$type['id']}, Nom: {$type['nom']}</p>";
        }
        nextButton($step, $lastId);
    } catch (\Exception $e) {
        logTest("Échec du listage des TypePiece : " . $e->getMessage(), false);
        nextButton($step, $lastId);
    }
}

// Étape 3 : Suppression du TypePiece créé
else if ($step == 3) {
    try {
        $sql = "DELETE FROM TypePiece WHERE id = ?";
        $conn->executeStatement($sql, [$lastId]);
        logTest("Suppression du TypePiece avec l'ID : $lastId");
        nextButton($step, $lastId);
    } catch (\Exception $e) {
        logTest("Échec de la suppression du TypePiece : " . $e->getMessage(), false);
        nextButton($step, $lastId);
    }
}

// Étape 4 : Vérification de la suppression
else if ($step == 4) {
    try {
        $sql = "SELECT COUNT(*) as count FROM TypePiece WHERE id = ?";
        $count = $conn->fetchOne($sql, [$lastId]);
        if ($count == 0) {
            logTest("Vérification : Le TypePiece a bien été supprimé.");
        } else {
            logTest("Erreur : Le TypePiece n'a pas été supprimé.", false);
        }
        echo "<p>Tous les tests sont terminés !</p>";
    } catch (\Exception $e) {
        logTest("Échec de la vérification de suppression : " . $e->getMessage(), false);
        echo "<p>Tous les tests sont terminés !</p>";
    }
}
