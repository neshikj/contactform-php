<?php
/**
 * All routes are defined here.
 *
 * Routes follow the format:
 *
 * [METHOD, ROUTE, CALLABLE]
 *
 * Routes can use optional segments and regular expressions. See nikic/fastroute for more details.
 */

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;

/** @var Dispatcher $dispatcher */
$dispatcher = FastRoute\simpleDispatcher(function(RouteCollector $r) {
    $r->addRoute('GET', '/', 'FormController');
    $r->addRoute('POST', '/', 'FormCreateController');
    $r->addRoute('POST', '/send', 'FormCreateAJAXController');
});

return $dispatcher;