<?php

namespace App;

// Include composer autoloader for PHPMailer and other dependencies
require_once __DIR__ . '/../../vendor/autoload.php';

/*
 *
 * TP : Routing
 *
 * Faire en sorte que toutes les requêtes HTTP pointent sur le fichier index.php se trouvant dans public
 * Se baser ensuite sur le fichier routes.yml pour appeler la bonne classe dans le dossier controller et
 * la bonne methode (ce que l'on appel une action dans un controller)
 *
 * Exemple :
 * http://localhost:8080/contact
 * Doit créer une instance de Base et appeler la méthode (action) : contact
 * $controller = new Base();
 * $controller->contact();
 *
 * Pensez à effectuer tous les nettoyages et toutes les vérifications pour
 * afficher des erreurs (des simples die suffiront dans un premier temps)
 *
 * Rendu : Mail y.skrzypczyk@gmail.com
 * Objet du mail : 3IW1 - TP routing - Nom Prénom
 * Contenu du mail : fichier index.php et les autres fichiers créés s'il y en a
 *
 * Bon courage
 */

spl_autoload_register(function ($class) {
    // Convert namespace to file path
    $classPath = str_replace("\\", "/", $class);
    $filePath = __DIR__ . "/../" . $classPath . ".php";
    if (file_exists($filePath)) {
        include $filePath;
    }
});


$requestUri = strtok($_SERVER["REQUEST_URI"], "?");

// Remove /phptest from the beginning if it exists
if (strpos($requestUri, '/phptest') === 0) {
    $requestUri = substr($requestUri, strlen('/phptest'));
}

// Default to "/" if empty
if (empty($requestUri)) {
    $requestUri = "/";
}

if (strlen($requestUri) > 1)
    $requestUri = rtrim($requestUri, "/");
$requestUri = strtolower($requestUri);

// Simple YAML parser for routes.yml
function parseYaml($file)
{
    $routes = [];
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $currentRoute = null;

    foreach ($lines as $line) {
        $trimmed = trim($line);

        // Skip comments
        if (empty($trimmed) || strpos($trimmed, '#') === 0) {
            continue;
        }

        // Route key (e.g., "/", "/contact")
        if (preg_match('/^([^:]+):\s*$/', $trimmed, $matches)) {
            $currentRoute = $matches[1];
            $routes[$currentRoute] = [];
        }
        // Key-value pair (e.g., "controller: Base")
        elseif ($currentRoute !== null && strpos($trimmed, ':') !== false) {
            list($key, $value) = array_map('trim', explode(':', $trimmed, 2));
            $routes[$currentRoute][$key] = $value;
        }
    }

    return $routes;
}

// Use absolute path to routes.yml
$routesFile = __DIR__ . '/../routes.yml';
$routes = parseYaml($routesFile);

//Vérifier que l'uri existe dans les routes
if (empty($routes[$requestUri])) {
    die("Aucune route pour cette uri : page 404");
}

if (empty($routes[$requestUri]["controller"]) || empty($routes[$requestUri]["action"])) {
    die("Aucun controller ou action pour cette uri : page 404");
}

$controller = $routes[$requestUri]["controller"];
$action = $routes[$requestUri]["action"];

$controllerFile = __DIR__ . "/../Controllers/" . $controller . ".php";
if (!file_exists($controllerFile)) {
    die("Aucun fichier controller pour cette uri");
}

include $controllerFile;

$controller = "App\\Controllers\\" . $controller;
if (!class_exists($controller)) {
    die("La classe du controller n'existe pas");
}

$objetController = new $controller();

if (!method_exists($objetController, $action)) {
    die("La methode du controller n'existe pas");
}

$objetController->$action();