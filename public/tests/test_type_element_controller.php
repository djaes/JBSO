<?php
// public/tests/test_type_element_controller.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require __DIR__ . '/../../vendor/autoload.php';

use JBSO\Controller\TypeElementController;

// Instancie le contrôleur
$controller = new TypeElementController();

// Test de la méthode list
echo "<h1>Test de list</h1>";
$controller->list();
// Test de la méthode show
echo "<h1>Test de show</h1>";
$controller->show(1);


