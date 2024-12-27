<?php

// src/Commerce/Products/Infrastructure/Controllers/ProductController.php
namespace Src\Commerce\Products\Infrastructure\Controllers;

use Src\Commerce\Products\Application\UseCases\ListProductUseCase;
use Src\Commerce\Products\Application\UseCases\ListProductsUseCase;
use Src\Commerce\Products\Application\UseCases\CreateProductUseCase;
use Src\Commerce\Products\Application\UseCases\UpdateProductUseCase;
use Src\Commerce\Products\Application\UseCases\DeleteProductUseCase;
use Src\Shared\Infrastructure\Formatters\ResponseFormatter;

final class ProductController
{
    private ListProductsUseCase $listProducts;
    private ListProductUseCase $listProduct;
    private CreateProductUseCase $createProduct;
    private UpdateProductUseCase $updateProduct;
    private DeleteProductUseCase $deleteProduct;

    public function __construct(
        ListProductsUseCase  $listProducts,
        ListProductUseCase   $listProduct,
        CreateProductUseCase $createProduct,
        UpdateProductUseCase $updateProduct,
        DeleteProductUseCase $deleteProduct
    ) {
        $this->listProducts = $listProducts;
        $this->listProduct = $listProduct;
        $this->createProduct = $createProduct;
        $this->updateProduct = $updateProduct;
        $this->deleteProduct = $deleteProduct;
    }

    /**
     * Retrieves all products.
     *
     * @return void
     */
    public function getAll(): void
    {
        try {
            $products = $this->listProducts->execute();
            header('Content-Type: application/json');
            echo json_encode(ResponseFormatter::success($products));
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(ResponseFormatter::error($e->getMessage()));
        }
    }

    /**
     * Retrieves a single product by its ID.
     *
     * @param int $id The ID of the product to be retrieved.
     * @return void
     */
    public function getOne($id): void
    {
        try {
            $product = $this->listProduct->execute($id);
            header('Content-Type: application/json');
            echo json_encode(ResponseFormatter::success($product));
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(ResponseFormatter::error($e->getMessage()));
        }
    }

    /**
     * Creates a new product.
     *
     * @return void
     */
    public function create(): void
    {
        try {
            $json = json_decode(file_get_contents('php://input'), true);
            $name = $json['name'] ?? '';
            $desc = $json['description'] ?? '';
            $price = $json['price'] ?? 0;

            $product = $this->createProduct->execute($name, $desc, (float)$price);

            header('Content-Type: application/json');
            echo json_encode(ResponseFormatter::success(['id' => $product->getId()->value()]));
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(ResponseFormatter::error($e->getMessage()));
        }
    }

    /**
     * Updates a product by its ID.
     *
     * @param int $id The ID of the product to be updated.
     * @return void
     */
    public function update($id): void
    {
        try {
            $json = json_decode(file_get_contents('php://input'), true);
            $newName = $json['name'] ?? null;
            $newDesc = $json['description'] ?? null;
            $newPrice = isset($json['price']) ? (float)$json['price'] : null;

            $this->updateProduct->execute($id, $newName, $newDesc, $newPrice);

            header('Content-Type: application/json');
            echo json_encode(ResponseFormatter::success(['status' => 'updated']));
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(ResponseFormatter::error($e->getMessage()));
        }
    }

    /**
     * Deletes a product by its ID.
     *
     * @param int $id The ID of the product to be deleted.
     * @return void
     */
    public function delete($id): void
    {
        try {
            $this->deleteProduct->execute($id);

            header('Content-Type: application/json');
            echo json_encode(ResponseFormatter::success(['status' => 'deleted']));
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(ResponseFormatter::error($e->getMessage()));
        }
    }
}