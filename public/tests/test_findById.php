<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../debug.php';
require_once __DIR__ . '/fonction.php';
backToIndexButton();
use JBSO\Entity\TypeFinition;
use JBSO\Entity\TypeElement;
use JBSO\Entity\TypePiece;
use JBSO\Entity\TypeAction;
use JBSO\Entity\TypeTache;
use JBSO\Entity\TypeCouleur;



$typeFinition = TypeFinition::findById(1);
$typeElement = TypeElement::findById(7);
$typePiece = TypePiece::findById(5);
$typeAction = TypeAction::findById(2);
$typeTache = TypeTache::findById(3);
$typeCouleur = TypeCouleur::findById(2);

if ($typeFinition) {
    echo "Degré de finition : " . $typeFinition->getLibelle(). "<br>";
    echo "type d'element : " . $typeElement->getLibelle(). "<br>";
    echo "type de pieces : " . $typePiece->getLibelle(). "<br>";
    echo "type d'action : " . $typeAction->getLibelle(). "<br>";
    echo "Tache : " . $typeTache->getLibelle(). "<br>";
    echo "couleur : " . $typeCouleur->getLibelle(). "<br>";
}
?>