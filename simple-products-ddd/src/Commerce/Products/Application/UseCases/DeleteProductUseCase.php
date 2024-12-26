<?php

namespace Src\Commerce\Products\Application\UseCases;

use Src\Commerce\Products\Domain\Repositories\ProductRepositoryInterface;

final class DeleteProductUseCase
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(string $productId): void
    {
        $product = $this->productRepository->findById($productId);
        if (!$product) {
            throw new \InvalidArgumentException("Product with ID $productId not found");
        }

        $this->productRepository->delete($productId);
    }
}