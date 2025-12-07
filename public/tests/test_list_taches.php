<?php
// public/test_list_taches.php
require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../debug.php';
require_once __DIR__ . '/fonction.php';
backToIndexButton();

use JBSO\Controller\TacheController;
use JBSO\Database\Connection;



// Initialiser la connexion
$connection = Connection::getConnection();

// Initialiser le contrôleur en passant la connexion
$tacheController = new TacheController($connection);

// Simuler une requête pour l'élément avec l'ID 1
$tacheController->listByElement(1);