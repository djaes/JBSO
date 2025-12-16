<?php
// src/Routes/routes.php

namespace JBSO\Routes;

use FastRoute\RouteCollector;
use JBSO\Controller\TypeElementController;
use JBSO\Controller\TypePieceController;
use JBSO\Controller\TypeTraitementController;
use JBSO\Controller\TypeTacheController;
use JBSO\Controller\TypeCouleurController;
use JBSO\Controller\TypeFinitionController;

use JBSO\Controller\TypeElementPieceController;  // ✅ Doit être 
use JBSO\Controller\TypeTacheElementTraitementController;  // ✅ Doit être 
use JBSO\Controller\ClientController;  // ✅ Doit être 
use JBSO\Controller\ChantierClientController;  // ✅ Doit être


class Routes
{
    public static function load(RouteCollector $r)
    {
        // Routes pour les types d'éléments
        $r->addRoute('GET', '/type-element', [TypeElementController::class, 'list']);
        $r->addRoute('GET', '/type-element/{id:\d+}', [TypeElementController::class, 'show']);
        $r->addRoute('GET', '/type-element/create', [TypeElementController::class, 'showCreateForm']);
        $r->addRoute('POST', '/type-element/create', [TypeElementController::class, 'create']);
        $r->addRoute('GET', '/type-element/{id:\d+}/update', [TypeElementController::class, 'showUpdateForm']);
        $r->addRoute('POST', '/type-element/{id:\d+}/update', [TypeElementController::class, 'update']);
        $r->addRoute('GET', '/type-element/{id:\d+}/delete', [TypeElementController::class, 'delete']);

        // Routes pour les types de pièces
        $r->addRoute('GET', '/type-piece', [TypePieceController::class, 'list']);
        $r->addRoute('GET', '/type-piece/{id:\d+}', [TypePieceController::class, 'show']);
        $r->addRoute('GET', '/type-piece/create', [TypePieceController::class, 'showCreateForm']);
        $r->addRoute('POST', '/type-piece/create', [TypePieceController::class, 'create']);
        $r->addRoute('GET', '/type-piece/{id:\d+}/update', [TypePieceController::class, 'showUpdateForm']);
        $r->addRoute('POST', '/type-piece/{id:\d+}/update', [TypePieceController::class, 'update']);
        $r->addRoute('GET', '/type-piece/{id:\d+}/delete', [TypePieceController::class, 'delete']);

        // Routes pour les types de traitement
        $r->addRoute('GET', '/type-traitement', [TypeTraitementController::class, 'list']);
        $r->addRoute('GET', '/type-traitement/{id:\d+}', [TypeTraitementController::class, 'show']);
        $r->addRoute('GET', '/type-traitement/create', [TypeTraitementController::class, 'showCreateForm']);
        $r->addRoute('POST', '/type-traitement/create', [TypeTraitementController::class, 'create']);
        $r->addRoute('GET', '/type-traitement/{id:\d+}/update', [TypeTraitementController::class, 'showUpdateForm']);
        $r->addRoute('POST', '/type-traitement/{id:\d+}/update', [TypeTraitementController::class, 'update']);
        $r->addRoute('GET', '/type-traitement/{id:\d+}/delete', [TypeTraitementController::class, 'delete']);

        // Routes pour les types de tâches
        $r->addRoute('GET', '/type-tache', [TypeTacheController::class, 'list']);
        $r->addRoute('GET', '/type-tache/{id:\d+}', [TypeTacheController::class, 'show']);
        $r->addRoute('GET', '/type-tache/create', [TypeTacheController::class, 'showCreateForm']);
        $r->addRoute('POST', '/type-tache/create', [TypeTacheController::class, 'create']);
        $r->addRoute('GET', '/type-tache/{id:\d+}/update', [TypeTacheController::class, 'showUpdateForm']);
        $r->addRoute('POST', '/type-tache/{id:\d+}/update', [TypeTacheController::class, 'update']);
        $r->addRoute('GET', '/type-tache/{id:\d+}/delete', [TypeTacheController::class, 'delete']);

        // Routes pour les types de couleurs
        $r->addRoute('GET', '/type-couleur', [TypeCouleurController::class, 'list']);
        $r->addRoute('GET', '/type-couleur/{id:\d+}', [TypeCouleurController::class, 'show']);
        $r->addRoute('GET', '/type-couleur/create', [TypeCouleurController::class, 'showCreateForm']);
        $r->addRoute('POST', '/type-couleur/create', [TypeCouleurController::class, 'create']);
        $r->addRoute('GET', '/type-couleur/{id:\d+}/update', [TypeCouleurController::class, 'showUpdateForm']);
        $r->addRoute('POST', '/type-couleur/{id:\d+}/update', [TypeCouleurController::class, 'update']);
        $r->addRoute('GET', '/type-couleur/{id:\d+}/delete', [TypeCouleurController::class, 'delete']);

        // Routes pour les types de finitions
        $r->addRoute('GET', '/type-finition', [TypeFinitionController::class, 'list']);
        $r->addRoute('GET', '/type-finition/{id:\d+}', [TypeFinitionController::class, 'show']);
        $r->addRoute('GET', '/type-finition/create', [TypeFinitionController::class, 'showCreateForm']);
        $r->addRoute('POST', '/type-finition/create', [TypeFinitionController::class, 'create']);
        $r->addRoute('GET', '/type-finition/{id:\d+}/update', [TypeFinitionController::class, 'showUpdateForm']);
        $r->addRoute('POST', '/type-finition/{id:\d+}/update', [TypeFinitionController::class, 'update']);
        $r->addRoute('GET', '/type-finition/{id:\d+}/delete', [TypeFinitionController::class, 'delete']);

        // Route pour la page d'accueil
        $r->addRoute('GET', '/', ['JBSO\Controller\HomeController', 'index']);
        
        // Routes pour les TypeElementPieceController
        $r->addRoute('GET', '/type-element-piece/create', [TypeElementPieceController::class, 'showCreateForm']);
        $r->addRoute('POST', '/type-element-piece/create', [TypeElementPieceController::class, 'create']);
        $r->addRoute('GET', '/type-element-piece/{id:\d+}/update', [TypeElementPieceController::class, 'showUpdateForm']);
        $r->addRoute('POST', '/type-element-piece/{id:\d+}/update', [TypeElementPieceController::class, 'update']);
        $r->addRoute('GET', '/type-element-piece/{id:\d+}/delete', [TypeElementPieceController::class, 'delete']);
        // Liste des associations entre types de pièces et types d'éléments
        $r->addRoute('GET', '/type-element-piece', [TypeElementPieceController::class, 'list']);

        // Afficher les types d'éléments associés à un type de pièce
        $r->addRoute('GET', '/type-element-piece/{id:\d+}', [TypeElementPieceController::class, 'show']);

        // Routes pour les TypeTacheElementTraitementController
        $r->addRoute('GET', '/type-tache-element-traitement/create', [TypeTacheElementTraitementController::class, 'showCreateForm']);
        $r->addRoute('POST', '/type-tache-element-traitement/create', [TypeTacheElementTraitementController::class, 'create']);
        $r->addRoute('GET', '/type-tache-element-traitement/{id:\d+}/update', [TypeTacheElementTraitementController::class, 'showUpdateForm']);
        $r->addRoute('POST', '/type-tache-element-traitement/{id:\d+}/update', [TypeTacheElementTraitementController::class, 'update']);
        $r->addRoute('GET', '/type-tache-element-traitement/{id:\d+}/delete', [TypeTacheElementTraitementController::class, 'delete']);
        // Liste des associations entre types de pièces et types d'éléments
        $r->addRoute('GET', '/type-tache-element-traitement', [TypeTacheElementTraitementController::class, 'list']);

        // Afficher les types d'éléments associés à un type de pièce
        $r->addRoute('GET', '/type-tache-element-traitement/{id:\d+}', [TypeTacheElementTraitementController::class, 'show']);


        // Routes pour Client
        $r->addRoute('GET', '/client', [ClientController::class, 'list']);
        $r->addRoute('GET', '/client/{id:\d+}', [ClientController::class, 'show']);
        $r->addRoute('GET', '/client/create', [ClientController::class, 'showCreateForm']);
        $r->addRoute('POST', '/client/create', [ClientController::class, 'create']);
        $r->addRoute('POST', '/client/{id:\d+}/update', [ClientController::class, 'update']);
        $r->addRoute('GET', '/client/{id:\d+}/update', [ClientController::class, 'showUpdateForm']);
        $r->addRoute('GET', '/client/{id:\d+}/delete', [ClientController::class, 'delete']);
        
        // Routes pour Chantier 
        $r->addRoute('GET', '/chantier-client', [ChantierClientController::class, 'list']);
        $r->addRoute('GET', '/chantier-client/{id:\d+}', [ChantierClientController::class, 'show']);
        $r->addRoute('GET', '/chantier-client/create', [ChantierClientController::class, 'showCreateForm']);
        $r->addRoute('POST', '/chantier-client/create', [ChantierClientController::class, 'create']);
        $r->addRoute('POST', '/chantier-client/{id:\d+}/update', [ChantierClientController::class, 'update']);
        $r->addRoute('GET', '/chantier-client/{id:\d+}/update', [ChantierClientController::class, 'showUpdateForm']);
        $r->addRoute('GET', '/chantier-client/{id:\d+}/delete', [ChantierClientController::class, 'delete']);
        
    }
}
