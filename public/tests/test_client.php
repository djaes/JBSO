<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../debug.php';
require_once __DIR__ . '/fonction.php';

use JBSO\Database\Connection;

$step = isset($_POST['step']) ? (int)$_POST['step'] : 1;
$lastId = isset($_POST['last_id']) ? (int)$_POST['last_id'] : 0;



echo "<h1>Test : Client</h1>";
backToIndexButton();


try {
    $conn = Connection::getConnection();
    logTest("Connexion à la base de données établie.");
} catch (\Exception $e) {
    logTest("Échec de la connexion à la base de données : " . $e->getMessage(), false);
    exit(1);
}

// Étape 1 : Création d'un Client
if ($step == 1) {
    try {
        $sql = "INSERT INTO Client (nom, adresse, telephone, email) VALUES ('Test Client', '123 Rue Test', '0123456789', 'test@example.com')";
        $conn->executeStatement($sql);
        $lastId = $conn->lastInsertId();
        logTest("Création d'un Client avec l'ID : $lastId");
        nextButton($step, $lastId);
    } catch (\Exception $e) {
        logTest("Échec de la création du Client : " . $e->getMessage(), false);
        nextButton($step);
    }
}

// Étape 2 : Listage des Clients
else if ($step == 2) {
    try {
        $sql = "SELECT * FROM Client";
        $clients = $conn->fetchAllAssociative($sql);
        logTest("Listage des Clients : " . count($clients) . " résultats.");
        foreach ($clients as $client) {
            echo "<p>- ID: {$client['id']}, Nom: {$client['nom']}</p>";
        }
        nextButton($step, $lastId);
    } catch (\Exception $e) {
        logTest("Échec du listage des Clients : " . $e->getMessage(), false);
        nextButton($step, $lastId);
    }
}

// Étape 3 : Suppression du Client créé
else if ($step == 3) {
    try {
        $sql = "DELETE FROM Client WHERE id = ?";
        $conn->executeStatement($sql, [$lastId]);
        logTest("Suppression du Client avec l'ID : $lastId");
        nextButton($step, $lastId);
    } catch (\Exception $e) {
        logTest("Échec de la suppression du Client : " . $e->getMessage(), false);
        nextButton($step, $lastId);
    }
}

// Étape 4 : Vérification de la suppression
else if ($step == 4) {
    try {
        $sql = "SELECT COUNT(*) as count FROM Client WHERE id = ?";
        $count = $conn->fetchOne($sql, [$lastId]);
        if ($count == 0) {
            logTest("Vérification : Le Client a bien été supprimé.");
        } else {
            logTest("Erreur : Le Client n'a pas été supprimé.", false);
        }
        echo "<p>Tous les tests sont terminés !</p>";
    } catch (\Exception $e) {
        logTest("Échec de la vérification de suppression : " . $e->getMessage(), false);
        echo "<p>Tous les tests sont terminés !</p>";
    }
}