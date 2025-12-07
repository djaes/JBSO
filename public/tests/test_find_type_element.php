<?php
// public/tests/test_find_type_element.php
require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../debug.php';
require_once __DIR__ . '/fonction.php';
backToIndexButton();

use JBSO\Repository\TypeElementRepository;
use JBSO\Database\Connection;

$connection = Connection::getConnection();
$repository = new TypeElementRepository($connection);

// Teste avec un ID existant dans ta base de données
$typeElement = $repository->findById(2);

if ($typeElement) {
    echo "Type d'élément trouvé : " . $typeElement->getNom();
} else {
    echo "Type d'élément non trouvé.";
}
?>