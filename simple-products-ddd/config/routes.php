<?php
declare(strict_types=1);

use Src\Commerce\Products\Infrastructure\Controllers\ProductController;

$router = new AltoRouter();
$router->setBasePath('/api/v1');
$router->map('GET', '/products', ['controller' => ProductController::class, 'action' => 'getAll'], 'list_products');
$router->map('GET', '/products/[i:id]', ['controller' => ProductController::class, 'action' => 'getOne'], 'list_product');
$router->map('POST', '/products', ['controller' => ProductController::class, 'action' => 'create'], 'create_product');
$router->map('PUT', '/products/[i:id]', ['controller' => ProductController::class, 'action' => 'update'], 'update_product');
$router->map('DELETE', '/products/[i:id]', ['controller' => ProductController::class, 'action' => 'delete'], 'delete_product');

return $router;