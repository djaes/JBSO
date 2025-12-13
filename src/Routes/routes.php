<?php
// src/Routes/routes.php

namespace JBSO\Routes;

use FastRoute\RouteCollector;
use JBSO\Controller\TypeElementController;
use JBSO\Controller\TypePieceController;
use JBSO\Controller\TypeActionController;
use JBSO\Controller\TypeTacheController;
use JBSO\Controller\TypeCouleurController;
use JBSO\Controller\TypeFinitionController;

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

        // Routes pour les types d'actions
        $r->addRoute('GET', '/type-action', [TypeActionController::class, 'list']);
        $r->addRoute('GET', '/type-action/{id:\d+}', [TypeActionController::class, 'show']);
        $r->addRoute('GET', '/type-action/create', [TypeActionController::class, 'showCreateForm']);
        $r->addRoute('POST', '/type-action/create', [TypeActionController::class, 'create']);
        $r->addRoute('GET', '/type-action/{id:\d+}/update', [TypeActionController::class, 'showUpdateForm']);
        $r->addRoute('POST', '/type-action/{id:\d+}/update', [TypeActionController::class, 'update']);
        $r->addRoute('GET', '/type-action/{id:\d+}/delete', [TypeActionController::class, 'delete']);

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
        // Liste des associations entre types de pièces et types d'éléments
        $r->addRoute('GET', '/type-element-piece', [TypeElementPieceController::class, 'list']);

        // Afficher les types d'éléments associés à un type de pièce
        $r->addRoute('GET', '/type-element-piece/{id:\d+}', [TypeElementPieceController::class, 'show']);

        // Afficher le formulaire pour gérer les types d'éléments associés à un type de pièce
        $r->addRoute('GET', '/type-element-piece/{id:\d+}/manage', [TypeElementPieceController::class, 'manageTypeElements']);

        // Sauvegarder les types d'éléments associés à un type de pièce
        $r->addRoute('POST', '/type-element-piece/{id:\d+}/save', [TypeElementPieceController::class, 'saveTypeElements']);

        // Supprimer une association entre un type de pièce et un type d'élément
        $r->addRoute('GET', '/type-element-piece/{typePieceId:\d+}/{typeElementId:\d+}/delete', [TypeElementPieceController::class, 'delete']);

    
    }
}
