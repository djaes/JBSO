<?php
// public/tests/test_type_element_repository.php

require __DIR__ . '/../../vendor/autoload.php';

use JBSO\Repository\TypeElementRepository;

// Instancie le repository
$repository = new TypeElementRepository();

// Test de la méthode findAll
echo "<h1>Test de findAll</h1>";
$typeElements = $repository->findAll();
echo "<pre>";
print_r($typeElements);
echo "</pre>";

// Test de la méthode findById
echo "<h1>Test de findById</h1>";
$typeElement = $repository->findById(1);
echo "<pre>";
print_r($typeElement);
echo "</pre>";

// Test de la méthode create
echo "<h1>Test de create</h1>";
$data = array(
            "libelle" => "Nouveau Type",
            "traitement" => "demonter",
        );
$id = $repository->create($data);
$newTypeElement = $repository->findById($id);
echo "<pre>";
print_r($newTypeElement);
echo "</pre>";

// Test de la méthode update
echo "<h1>Test de update</h1>";
$data = array(
            "libelle" => "Type Mis à Jour",
            "traitement" => "masquer",
        );
$success = $repository->update($id, $data);
$updatedTypeElement = $repository->findById($id);
echo "<pre>";
print_r($updatedTypeElement);
echo "</pre>";

// Test de la méthode delete
echo "<h1>Test de delete</h1>";
$success = $repository->delete($id);
echo $success ? "Suppression réussie" : "Échec de la suppression";
