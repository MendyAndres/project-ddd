<?php

use Src\Commerce\Products\Application\UseCases\CreateProductUseCase;
use Src\Commerce\Products\Application\UseCases\DeleteProductUseCase;
use Src\Commerce\Products\Application\UseCases\ListProductsUseCase;
use Src\Commerce\Products\Application\UseCases\ListProductUseCase;
use Src\Commerce\Products\Application\UseCases\UpdateProductUseCase;
use Src\Commerce\Products\Domain\Services\IdGeneratorInterface;
use Src\Commerce\Products\Infrastructure\Container;
use Src\Commerce\Products\Domain\Repositories\ProductRepositoryInterface;
use Src\Commerce\Products\Infrastructure\Controllers\ProductController;
use Src\Commerce\Products\Infrastructure\Repositories\PdoProductRepository;
use Src\Commerce\Products\Infrastructure\Services\IdGenerator;

return static function (Container $container) {
    $container->bind(
        ProductRepositoryInterface::class,
        function () {
            $dns = sprintf(
                'mysql:host=%s;port=%s;dbname=%s',
                $_ENV['DB_HOST'],
                $_ENV['DB_PORT'],
                $_ENV['DB_NAME']
            );

            $pdo = new PDO($dns, $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return new PdoProductRepository($pdo);
        }
    );

    //uses cases
    $container->bind(ListProductUseCase::class, ListProductUseCase::class);
    $container->bind(ListProductsUseCase::class, ListProductsUseCase::class);
    $container->bind(CreateProductUseCase::class, CreateProductUseCase::class);
    $container->bind(UpdateProductUseCase::class, UpdateProductUseCase::class);
    $container->bind(DeleteProductUseCase::class, DeleteProductUseCase::class);

    //services
    $container->bind(IdGeneratorInterface::class, IdGenerator::class);

    //controllers
    $container->bind(ProductController::class, ProductController::class);
};