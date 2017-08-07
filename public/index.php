<?php
/**
 * This is the main bootstrap file.
 *
 * It loads the DI configurations `app/di.php`, sets up routes,
 * loads configuration variables and then calls the controller defined in the routes.
 *
 * Autowiring and annotation use is on, so easy dependency injection is enabled
 * by default.
 */

$container = require __DIR__ . '/../app/bootstrap.php';
$routeDispatcher = require __DIR__.'/../app/routes.php';

$routeInfo = $routeDispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo $container->get(Twig_Environment::class)->render('404.twig');
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        echo $container->get(Twig_Environment::class)->render('405.twig');
        break;
    case FastRoute\Dispatcher::FOUND:
        $controller = $routeInfo[1];
        $params = $routeInfo[2];

        $container->get($controller);
        break;
}
