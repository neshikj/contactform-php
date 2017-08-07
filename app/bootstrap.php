<?php
/**
 * The bootstrap file creates and returns the container.
 *
 * It also loads the ENV file into our app.
 */

use DI\ContainerBuilder;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

// Load .env into our app
$env = new Dotenv(__DIR__.'/../');
$env->load();

$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions(require_once __DIR__ . '/di.php');
$container = $containerBuilder->build();

return $container;