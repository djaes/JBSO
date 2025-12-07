<?php
// src/Routes/routes.php

use FastRoute\RouteCollector;

use JBSO\Controller\DegreFinitionController;
use JBSO\Controller\ElementController;
use JBSO\Controller\TacheController;

return function(RouteCollector $r) {
    // Route pour la page de test
    $dispatcher->addRoute('GET', '/test/degre_finition/create', [DegreFinitionController::class, 'create']);
    $dispatcher->addRoute('POST', '/test/degre_finition/create', [DegreFinitionController::class, 'create']);
    $dispatcher->addRoute('GET', '/test/degre_finition/list', [DegreFinitionController::class, 'list']);
    $dispatcher->addRoute('GET', '/test/degre_finition/delete/{id:\d+}', [DegreFinitionController::class, 'delete']);


    // Route pour la page d'accueil
    $r->addRoute('GET', '/', [ElementController::class, 'showHome']);

    // Routes pour les éléments
    $r->addRoute('GET', '/element/create', [ElementController::class, 'showCreateForm']);  // Formulaire de création
    $r->addRoute('POST', '/element/create', [ElementController::class, 'createElement']);  // Création d'un élément
    $r->addRoute('GET', '/element/{id:\d+}', [ElementController::class, 'showElement']);  // Détail d'un élément
    $r->addRoute('GET', '/element/{id:\d+}/edit', [ElementController::class, 'showEditForm']);  // Formulaire d'édition
    $r->addRoute('POST', '/element/{id:\d+}/edit', [ElementController::class, 'updateElement']);  // Mise à jour d'un élément

    // Routes pour les tâches
    $r->addRoute('GET', '/tache/list/{elementId:\d+}', [TacheController::class, 'listByElement']);  // Liste des tâches d'un élément
    $r->addRoute('GET', '/tache/start/{tacheElementId:\d+}', [TacheController::class, 'startTache']);  // Démarrer une tâche
    $r->addRoute('GET', '/tache/finish/{tacheElementId:\d+}', [TacheController::class, 'finishTache']);  // Terminer une tâche
    // Ajoute ici d'autres routes...
};
