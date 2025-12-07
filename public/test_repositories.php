<?php
require_once '../vendor/autoload.php';
require_once '../debug.php';

use JBSO\Entity\Element;
use JBSO\Repository\ElementRepository;

// Test de la sauvegarde d'un élément
$element = new Element();
$element->setNom("plafond du salon ");
$element->setTypeElement("plafond");
$element->setPiece("Salon");
$element->setDegreFinition("soigné");

$elementRepository = new ElementRepository();
$elementId = $elementRepository->save($element);

echo "Élément sauvegardé avec l'ID : " . $elementId . "\n";

// Test de la récupération de tous les éléments
$elements = $elementRepository->findAll();
print_r($elements);
