<?php


require __DIR__ . '/vendor/autoload.php';

use Src\Commerce\Products\Domain\Services\IdGeneratorInterface;
use Src\Commerce\Products\Infrastructure\Container;
use Src\Commerce\Products\Infrastructure\Controllers\ProductController;
use Src\Commerce\Products\Application\UseCases\ListProductsUseCase;
use Src\Commerce\Products\Application\UseCases\CreateProductUseCase;
use Src\Commerce\Products\Application\UseCases\UpdateProductUseCase;
use Src\Commerce\Products\Application\UseCases\DeleteProductUseCase;
use Src\Commerce\Products\Domain\Repositories\ProductRepositoryInterface;
use Src\Commerce\Products\Infrastructure\Repositories\PdoProductRepository;
use Src\Commerce\Products\Infrastructure\Services\IdGenerator;

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Max-Age: 86400");
    http_response_code(200);
    exit();
}

$router = new AltoRouter();
$router->setBasePath('/api/v1');

$router->map('GET', '/products', ['controller' => ProductController::class, 'action' => 'getAll'], 'list_products');
$router->map('POST', '/products', ['controller' => ProductController::class, 'action' => 'create'], 'create_product');
$router->map('PUT', '/products/[i:id]', ['controller' => ProductController::class, 'action' => 'update'], 'update_product');
$router->map('DELETE', '/products/[i:id]', ['controller' => ProductController::class, 'action' => 'delete'], 'delete_product');

//$router->map('GET', '/products/[i:id]', function ($id) {
//    (new GetProductAction())($id);
//});
//
//$router->map('POST', '/products', function () {
//    (new CreateProductAction())();
//});
//
//$router->map('PUT', '/products/[i:id]', function ($id) {
//    (new UpdateProductAction())($id);
//});
//
//$router->map('DELETE', '/products/[i:id]', function ($id) {
//    (new DeleteProductAction())($id);
//});

$match = $router->match();

$pdo = new PDO('mysql:host=mysql;dbname=simple_products_ddd', 'user', 'pass');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$container = new Container();

// Registrar la implementación del repositorio
$container->bind(
    ProductRepositoryInterface::class,
    function (Container $c) {
        // Aquí creas tu instancia, p.e. inyectando un PDO
        // y retornas un 'new PdoProductRepository($pdo)'

        $pdo = new PDO('mysql:host=mysql;dbname=simple_products_ddd', 'user', 'pass');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return new PdoProductRepository($pdo);
    }
);

// Registrar los UseCases (si tu contenedor hace autowiring por Reflection,
// podrías no necesitar registrar cada uno, depende de tu Container)
$container->bind(ListProductsUseCase::class, ListProductsUseCase::class);
$container->bind(CreateProductUseCase::class, CreateProductUseCase::class);
$container->bind(UpdateProductUseCase::class, UpdateProductUseCase::class);
$container->bind(DeleteProductUseCase::class, DeleteProductUseCase::class);
$container->bind(IdGeneratorInterface::class, IdGenerator::class);

// Registrar el controlador
$container->bind(ProductController::class, ProductController::class);

if ($match && is_array($match['target'])) {
    // $match['target'] = ['controller' => ProductController::class, 'action' => 'getAll']
    $controllerClass = $match['target']['controller'];
    $action = $match['target']['action'];
    $params = $match['params'] ?? [];

    // Instanciamos el controlador mediante el contenedor
    /** @var ProductController $controller */
    $controller = $container->make($controllerClass);

    if (!method_exists($controller, $action)) {
        header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
        echo "Action '$action' not found on controller '$controllerClass'.";
        exit;
    }

    // Llamar al método, pasando los parámetros de la ruta (ej: id)
    $controller->$action(...array_values($params));
} else {
    // No hay match
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    echo "Route not found.";
}
