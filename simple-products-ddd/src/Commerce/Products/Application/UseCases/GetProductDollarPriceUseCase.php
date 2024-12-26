<?php

declare(strict_types=1);

namespace Src\Commerce\Products\Application\UseCases;

use Src\Commerce\Products\Domain\Repositories\ProductRepositoryInterface;
use Src\Commerce\Products\Domain\Services\CurrencyConverterInterface;

final class GetProductDollarPriceUseCase
{
    private ProductRepositoryInterface $productRepository;
    private CurrencyConverterInterface $currencyConverter;

    public function __construct(ProductRepositoryInterface $productRepository, CurrencyConverterInterface $currencyConverter)
    {
        $this->productRepository = $productRepository;
        $this->currencyConverter = $currencyConverter;
    }

    public function execute(string $productId): float
    {
        $product = $this->productRepository->findById($productId);
        if (!$product) {
            throw new \InvalidArgumentException("Product with ID $productId not found");
        }

        return $this->currencyConverter->convertToDollars($product->getPrice());
    }
}