<?php
// src/Routes/routes.php

namespace JBSO\Routes;

use FastRoute\RouteCollector;

class Routes
{
    public static function load(RouteCollector $r)
    {
        // Route pour la page d'accueil
        $r->addRoute('GET', '/', ['JBSO\Controller\HomeController', 'index']);
        
        
        // Routes pour les types d'éléments
        $r->addRoute('GET', '/type-element', ['JBSO\Controller\TypeElementController', 'list']);
        $r->addRoute('GET', '/type-element/{id:\d+}', ['JBSO\Controller\TypeElementController', 'show']);
        $r->addRoute('GET', '/type-element/create', ['JBSO\Controller\TypeElementController', 'showCreateForm']);
        $r->addRoute('POST', '/type-element/create', ['JBSO\Controller\TypeElementController', 'create']);


        // Routes pour les types de pièces
        $r->addRoute('GET', '/type-piece', ['JBSO\Controller\TypePieceController', 'list']);
        $r->addRoute('GET', '/type-piece/{id:\d+}', ['JBSO\Controller\TypePieceController', 'show']);
        $r->addRoute('GET', '/type-piece/create', ['JBSO\Controller\TypePieceController', 'showCreateForm']);
        $r->addRoute('POST', '/type-piece/create', ['JBSO\Controller\TypePieceController', 'create']);

        // Routes pour les types d'actions
        $r->addRoute('GET', '/type-action', ['JBSO\Controller\TypeActionController', 'list']);
        $r->addRoute('GET', '/type-action/{id:\d+}', ['JBSO\Controller\TypeActionController', 'show']);
        $r->addRoute('GET', '/type-action/create', ['JBSO\Controller\TypeActionController', 'showCreateForm']);
        $r->addRoute('POST', '/type-action/create', ['JBSO\Controller\TypeActionController', 'create']);

        // Routes pour les types de tâches
        $r->addRoute('GET', '/type-tache', ['JBSO\Controller\TypeTacheController', 'list']);
        $r->addRoute('GET', '/type-tache/{id:\d+}', ['JBSO\Controller\TypeTacheController', 'show']);
        $r->addRoute('GET', '/type-tache/create', ['JBSO\Controller\TypeTacheController', 'showCreateForm']);
        $r->addRoute('POST', '/type-tache/create', ['JBSO\Controller\TypeTacheController', 'create']);

        // Routes pour les types de couleurs
        $r->addRoute('GET', '/type-couleur', ['JBSO\Controller\TypeCouleurController', 'list']);
        $r->addRoute('GET', '/type-couleur/{id:\d+}', ['JBSO\Controller\TypeCouleurController', 'show']);
        $r->addRoute('GET', '/type-couleur/create', ['JBSO\Controller\TypeCouleurController', 'showCreateForm']);
        $r->addRoute('POST', '/type-couleur/create', ['JBSO\Controller\TypeCouleurController', 'create']);

        // Routes pour les types de finitions
        $r->addRoute('GET', '/type-finition', ['JBSO\Controller\TypeFinitionController', 'list']);
        $r->addRoute('GET', '/type-finition/{id:\d+}', ['JBSO\Controller\TypeFinitionController', 'show']);
        $r->addRoute('GET', '/type-finition/create', ['JBSO\Controller\TypeFinitionController', 'showCreateForm']);
        $r->addRoute('POST', '/type-finition/create', ['JBSO\Controller\TypeFinitionController', 'create']);

        

        
    }
}
