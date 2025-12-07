<?php
// public/index.php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../debug.php';
use FastRoute;
use JBSO\Routes\Routes;

// Crée le dispatcher FastRoute
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    Routes::load($r);
});


// Récupère la méthode HTTP et l'URI
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Supprime la query string de l'URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

// Dispatch la requête
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // Gérer les erreurs 404
        header("HTTP/1.0 404 Not Found");
        echo "404 - Page non trouvée";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // Gérer les erreurs 405
        header("HTTP/1.0 405 Method Not Allowed");
        echo "405 - Méthode non autorisée";
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        // Appelle le contrôleur avec les paramètres
        if (is_callable($handler)) {
            call_user_func_array($handler, $vars);
        } else {
            [$controller, $method] = $handler;
            $controllerInstance = new $controller();
            call_user_func_array([$controllerInstance, $method], $vars);
        }
        break;
}