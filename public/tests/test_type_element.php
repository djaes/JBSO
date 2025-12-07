<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use JBSO\Database\Connection;
use JBSO\Entity\TypeElement;
use JBSO\Repository\TypeElementRepository;

$step = isset($_POST['step']) ? (int)$_POST['step'] : 1;
$lastId = isset($_POST['last_id']) ? (int)$_POST['last_id'] : 0;

function logTest($message, $success = true) {
    echo "<p style='color: ".($success ? "green" : "red").";'>[".($success ? "SUCCESS" : "ERROR")."] $message</p>";
}

function nextButton($step, $lastId = 0) {
    echo '<form method="post" style="margin: 15px 0;">';
    echo '<input type="hidden" name="step" value="'.($step + 1).'">';
    echo '<input type="hidden" name="last_id" value="'.$lastId.'">';
    echo '<button type="submit" style="padding: 8px 15px; background: #4CAF50; color: white; border: none; cursor: pointer;">Suivant →</button>';
    echo '</form>';
}

function backToIndexButton() {
    echo '<div style="margin: 20px 0;">';
    echo '<a href="index.php" style="padding: 8px 15px; background: #f44336; color: white; text-decoration: none;">← Retour à l\'index</a>';
    echo '</div>';
}

echo "<h1>Test : TypeElement</h1>";
backToIndexButton();

try {
    $conn = Connection::getConnection();
    logTest("Connexion à la base de données établie.");
} catch (\Exception $e) {
    logTest("Échec de la connexion à la base de données : " . $e->getMessage(), false);
    exit(1);
}

// Étape 1 : Création d'un TypeElement avec traitement
if ($step == 1) {
    try {
        $typeElement = new TypeElement();
        $typeElement->setNom("Test TypeElement");
        $typeElement->setTraitement("à démonter"); // Exemple de traitement

        $repository = new TypeElementRepository();
        $lastId = $repository->save($typeElement);
        logTest("Création d'un TypeElement avec l'ID : $lastId");
        nextButton($step, $lastId);
    } catch (\Exception $e) {
        logTest("Échec de la création du TypeElement : " . $e->getMessage(), false);
        nextButton($step);
    }
}

// Étape 2 : Listage des TypeElement
else if ($step == 2) {
    try {
        $repository = new TypeElementRepository();
        $typeElements = $repository->findAll();
        logTest("Listage des TypeElement : " . count($typeElements) . " résultats.");
        foreach ($typeElements as $typeElement) {
            echo "<p>- ID: {$typeElement->getId()}, Nom: {$typeElement->getNom()}, Traitement: {$typeElement->getTraitement()}</p>";
        }
        nextButton($step, $lastId);
    } catch (\Exception $e) {
        logTest("Échec du listage des TypeElement : " . $e->getMessage(), false);
        nextButton($step, $lastId);
    }
}

// Étape 3 : Suppression du TypeElement créé
else if ($step == 3) {
    try {
        $repository = new TypeElementRepository();
        $repository->delete($lastId);
        logTest("Suppression du TypeElement avec l'ID : $lastId");
        nextButton($step, $lastId);
    } catch (\Exception $e) {
        logTest("Échec de la suppression du TypeElement : " . $e->getMessage(), false);
        nextButton($step, $lastId);
    }
}

// Étape 4 : Vérification de la suppression
else if ($step == 4) {
    try {
        $repository = new TypeElementRepository();
        $typeElement = $repository->findById($lastId);
        if ($typeElement === null) {
            logTest("Vérification : Le TypeElement a bien été supprimé.");
        } else {
            logTest("Erreur : Le TypeElement n'a pas été supprimé.", false);
        }
        echo "<p>Tous les tests sont terminés !</p>";
        backToIndexButton();
    } catch (\Exception $e) {
        logTest("Échec de la vérification de suppression : " . $e->getMessage(), false);
        echo "<p>Tous les tests sont terminés !</p>";
        backToIndexButton();
    }
}
