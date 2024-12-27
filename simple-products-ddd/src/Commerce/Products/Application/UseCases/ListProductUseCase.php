<?php

declare(strict_types=1);

namespace Src\Commerce\Products\Application\UseCases;

use Src\Commerce\Products\Application\DTOs\ProductDTO;
use Src\Commerce\Products\Domain\Repositories\ProductRepositoryInterface;

final class ListProductUseCase
{
    private ProductRepositoryInterface $repository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->repository = $productRepository;
    }

    /**
     * Executes the use case to list a product by its ID.
     *
     * @param string $id The ID of the product to retrieve.
     * @return ProductDTO The product data transfer object.
     */
    public function execute(string $id): ProductDTO
    {
        $products = $this->repository->findById($id);
        return ProductDTO::fromProduct($products);
    }
}