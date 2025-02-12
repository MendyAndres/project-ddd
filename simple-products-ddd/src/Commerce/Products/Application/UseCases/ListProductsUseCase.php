<?php

declare(strict_types=1);

namespace Src\Commerce\Products\Application\UseCases;

use Src\Commerce\Products\Application\DTOs\ProductDTO;
use Src\Commerce\Products\Domain\Repositories\ProductRepositoryInterface;

final class ListProductsUseCase
{
    private ProductRepositoryInterface $repository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->repository = $productRepository;
    }

    /**
     * Executes the use case to list all products.
     *
     * This method retrieves all products from the repository and maps them to ProductDTO objects.
     *
     * @return array An array of ProductDTO objects representing the products.
     */
    public function execute(): array
    {
        $products = $this->repository->findAll();
        return array_map(fn($product) => ProductDTO::fromProduct($products), $products);
    }
}