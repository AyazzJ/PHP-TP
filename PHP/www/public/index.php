<?php


$routes = require_once __DIR__ . '/routes.php';

require_once __DIR__ . '/../Controllers/Base.php';


$requestUri = $_SERVER["REQUEST_URI"] ?? "/";
$uri = strtok($requestUri, "?");

if ($uri == "") {
    $uri = "/";
}

if (isset($routes[$uri])) {

    $controllerName = $routes[$uri]["controller"];
    $actionName = $routes[$uri]["action"];

    if (!class_exists($controllerName)) {
        die("Error: controller not found : " . $controllerName);
    }

    $controller = new $controllerName();

    if (!method_exists($controller, $actionName)) {
        die("Error: action not found : " . $actionName);
    }

    $controller->$actionName();

} else {

    
    if (class_exists('Base')) {
        $base = new Base();
        if (method_exists($base, "error404")) {
            $base->error404();
        } else {
            echo "404 page not found";
        }
    } else {
        echo "404 page not found (Router initialization failed)";
    }
}