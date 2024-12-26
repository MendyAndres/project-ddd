<?php

declare(strict_types=1);

namespace Src\Commerce\Products\Application\UseCases;

use InvalidArgumentException;
use Src\Commerce\Products\Domain\Repositories\ProductRepositoryInterface;
use Src\Commerce\Products\Domain\ValueObjects\Products\ProductPrice;

final class UpdateProductPriceUseCase
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(string $productId, float $newPrice): void
    {
        if ($newPrice <= 0) {
            throw new InvalidArgumentException('Invalid price');
        }

        $product = $this->productRepository->findById($productId);
        if (!$product) {
            throw new \InvalidArgumentException("Product with ID $productId not found");
        }

        $product->updatePrice(new ProductPrice($newPrice));

        $this->productRepository->save($product);
    }
}