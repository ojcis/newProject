<?php

require_once '../vendor/autoload.php';

use App\Controllers\CryptocurrencyController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\ProfileController;
use App\Controllers\ValetController;
use App\Redirect;
use App\Template;
use App\ViewVariables\ViewVariables;
use App\ViewVariables\ErrorViewVariables;
use App\ViewVariables\UserViewVariables;
use Dotenv\Dotenv;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use function FastRoute\simpleDispatcher;

session_start();

$dotenv = Dotenv::createImmutable(__DIR__,'../.env');
$dotenv->load();

$loader = new FilesystemLoader('../views');
$twig = new Environment($loader);

$viewVariables = [
    ErrorViewVariables::class,
    UserViewVariables::class
];
/** @var ViewVariables $variable */
foreach ($viewVariables as $variable) {
    $variable = new $variable;
    $twig->addGlobal($variable->getName(), $variable->getValue());
}

$dispatcher = simpleDispatcher(function (RouteCollector $route) {
    $route->addRoute('GET', '/', [CryptocurrencyController::class, 'index']);
    $route->addRoute('POST', '/', [CryptocurrencyController::class, 'buy']);
    $route->addRoute('GET', '/register', [RegisterController::class, 'showForm']);
    $route->addRoute('POST', '/register', [RegisterController::class, 'register']);
    $route->addRoute('GET', '/login', [LoginController::class, 'showForm']);
    $route->addRoute('POST', '/login', [LoginController::class, 'login']);
    $route->addRoute('GET', '/logout', [LoginController::class, 'logout']);
    $route->addRoute('GET', '/profile', [ProfileController::class, 'showForm']);
    $route->addRoute('POST', '/profile=changeName', [ProfileController::class, 'changeName']);
    $route->addRoute('POST', '/profile=changeEmail', [ProfileController::class, 'changeEmail']);
    $route->addRoute('POST', '/profile=changePassword', [ProfileController::class, 'changePassword']);
    $route->addRoute('POST', '/profile=deleteAccount', [ProfileController::class, 'deleteAccount']);
    $route->addRoute('POST', '/profile=addMoney', [ProfileController::class, 'addMoney']);
    $route->addRoute('GET','/valet',[ValetController::class,'showForm']);
    $route->addRoute('POST','/valet=buy',[ValetController::class,'buy']);
    $route->addRoute('POST','/valet=sell',[ValetController::class,'sell']);


});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controller, $method] = $handler;

        $response = (new $controller)->$method($vars);

        if ($response instanceof Template) {
            echo $twig->render($response->getPath(), $response->getData());
            unset($_SESSION['user']);
            unset($_SESSION['error']);
        }
        if ($response instanceof Redirect) {
            header('Location: ' . $response->getUrl());
        }
        break;
}