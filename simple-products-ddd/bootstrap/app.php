<?php
declare(strict_types=1);

use Dotenv\Dotenv;
use Src\Commerce\Products\Infrastructure\Container;

// .env loading
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$container = new Container();

$dependencies = require dirname(__DIR__) . '/config/dependencies.php';
$dependencies($container);

$router = require dirname(__DIR__) . '/config/routes.php';

return [
    'container' => $container,
    'router' => $router,
];