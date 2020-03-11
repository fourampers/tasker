<?php

use DI\ContainerBuilder;
use League\Plates\Engine;
use Plasticbrain\FlashMessages\FlashMessages;
use Aura\SqlQuery\QueryFactory;
use FastRoute\RouteCollector;


if (!session_id()) @session_start();

$containerBuilder = new ContainerBuilder;

$containerBuilder->addDefinitions([
    Engine::class => function() {
        return new Engine('../app/views');
    },
    FlashMessages::class => function() {
        return new FlashMessages();
    },
    PDO::class => function() {
        return new PDO(config("database.type") . ":host=" . config("database.host") . ";dbname=" . config("database.name") , config("database.user") , config("database.password"));
    },
    QueryFactory::class => function() {
        return new QueryFactory('mysql');
    }
]);

$container = $containerBuilder->build();

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET',  '/',       ["App\Controllers\TaskController", "index"]);
    $r->addRoute('GET',  '/test',   ["App\Controllers\TaskController", "test"]);
    $r->addRoute('GET',  '/create', ["App\Controllers\TaskController", "create"]);
    $r->addRoute('POST', '/store',  ["App\Controllers\TaskController", "store"]);
    $r->addRoute('GET',  '/admin',  ["App\Controllers\AdminController", "index"]);
    $r->addRoute('GET',  '/login',  ["App\Controllers\AdminController", "login"]);
    $r->addRoute('POST', '/login',  ["App\Controllers\AdminController", "attempt"]);
    $r->addRoute('GET',  '/logout', ["App\Controllers\AdminController", "logout"]);
    $r->addGroup('/task', function (RouteCollector $r) {
        $r->addRoute('GET',  '/{id:\d+}/done', ["App\Controllers\TaskController", "updateStatus"]);
        $r->addRoute('GET',  '/{id:\d+}/edit', ["App\Controllers\TaskController", "content"]);
        $r->addRoute('POST', '/{id:\d+}/edit', ["App\Controllers\TaskController", "updateContent"]);
    });
    //$r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
    //$r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
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
$handler = $routeInfo[1];

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ...
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ...
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $container->call($handler, $vars);
        break;
}


