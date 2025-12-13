<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use JBSO\Database\Connection;
use JBSO\Repository\TypeElementPieceRepository;
use JBSO\Controller\TypeElementPieceController;

// Initialisation du contrôleur
$db = Connection::getConnection();
$repository = new TypeElementPieceRepository($db);
$controller = new TypeElementPieceController($repository);

// Simuler une requête GET pour lister les types de pièces
echo "<h2>Test de la route : Liste des types de pièces</h2>";
$controller->listTypePieces();

// Simuler une requête GET pour gérer les types d'éléments
$typePieceId = 1; // Remplace par un ID valide
echo "<h2>Test de la route : Gestion des types d'éléments pour le type de pièce $typePieceId</h2>";
$controller->manageTypeElements($typePieceId);

// Simuler une requête POST pour sauvegarder les types d'éléments
$_POST['type_elements'] = [1, 2, 3]; // Simuler une soumission de formulaire
echo "<h2>Test de la route : Sauvegarde des types d'éléments pour le type de pièce $typePieceId</h2>";
$controller->saveTypeElements($typePieceId);
