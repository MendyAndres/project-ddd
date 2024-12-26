<?php

// src/Commerce/Products/Infrastructure/Controllers/ProductController.php
namespace Src\Commerce\Products\Infrastructure\Controllers;

use Src\Commerce\Products\Application\UseCases\ListProductsUseCase;
use Src\Commerce\Products\Application\UseCases\CreateProductUseCase;
use Src\Commerce\Products\Application\UseCases\UpdateProductUseCase;
use Src\Commerce\Products\Application\UseCases\DeleteProductUseCase;

final class ProductController
{
    // Podrías inyectar varios use cases en el constructor
    // o instanciarlos uno a uno si prefieres.
    // Para este ejemplo, mostramos "inyección total".

    private ListProductsUseCase $listProducts;
    private CreateProductUseCase $createProduct;
    private UpdateProductUseCase $updateProduct;
    private DeleteProductUseCase $deleteProduct;

    public function __construct(
        ListProductsUseCase $listProducts,
        CreateProductUseCase $createProduct,
        UpdateProductUseCase $updateProduct,
        DeleteProductUseCase $deleteProduct
    ) {
        $this->listProducts = $listProducts;
        $this->createProduct = $createProduct;
        $this->updateProduct = $updateProduct;
        $this->deleteProduct = $deleteProduct;
    }

    public function getAll(): void
    {
        $products = $this->listProducts->execute();
        // Retornar en JSON, por ejemplo
        header('Content-Type: application/json');
        echo json_encode(array_map(fn($p) => [
            'id'          => $p->getId()->value(),
            'name'        => $p->getName()->value(),
            'description' => $p->getDescription()->value(),
            'price'       => $p->getPrice()->value(),
        ], $products));
    }

    public function create(): void
    {
        // Ejemplo: obtener datos de $_POST, o php://input, etc.
        $json = json_decode(file_get_contents('php://input'), true);
        $name = $json['name'] ?? '';
        $desc = $json['description'] ?? '';
        $price = $json['price'] ?? 0;

        $product = $this->createProduct->execute($name, $desc, (float)$price);

        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'ok',
            'id' => $product->getId()->value(),
        ]);
    }

    public function update($id): void
    {
        // Supongamos que update recibe name, description y price
        $json = json_decode(file_get_contents('php://input'), true);
        $newName = $json['name'] ?? null;
        $newDesc = $json['description'] ?? null;
        $newPrice = isset($json['price']) ? (float)$json['price'] : null;

        $this->updateProduct->execute($id, $newName, $newDesc, $newPrice);

        header('Content-Type: application/json');
        echo json_encode(['status' => 'updated']);
    }

    public function delete($id): void
    {
        $this->deleteProduct->execute($id);

        header('Content-Type: application/json');
        echo json_encode(['status' => 'deleted']);
    }
}