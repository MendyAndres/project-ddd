<?php

declare(strict_types=1);

namespace Src\Commerce\Products\Application\UseCases;

use InvalidArgumentException;
use Src\Commerce\Products\Domain\Factories\ProductFactory;
use Src\Commerce\Products\Domain\Models\Product;
use Src\Commerce\Products\Domain\Repositories\ProductRepositoryInterface;
use Src\Commerce\Products\Domain\Services\IdGeneratorInterface;

final class CreateProductUseCase
{
    private IdGeneratorInterface $idGenerator;
    private ProductRepositoryInterface $productRepository;
    private ProductFactory $productFactory;

    public function __construct(
        IdGeneratorInterface $idGenerator,
        ProductRepositoryInterface $productRepository,
        ProductFactory $productFactory
    ) {
        $this->idGenerator = $idGenerator;
        $this->productRepository = $productRepository;
        $this->productFactory = $productFactory;
    }

    /**
     * Executes the use case to create a new product.
     *
     * @param string $name The name of the product.
     * @param string $description The description of the product.
     * @param float $price The price of the product.
     * @return Product The created product.
     * @throws InvalidArgumentException If the product data is invalid.
     */
    public function execute(string $name, string $description, float $price): Product
    {
        if (empty($name) || empty($description) || $price <= 0) {
            throw new InvalidArgumentException('Invalid product data');
        }

        $product = $this->productFactory->create(
            $this->idGenerator->generateId(),
            $name,
            $description,
            $price
        );

        $this->productRepository->save($product);

        return $product;
    }
}