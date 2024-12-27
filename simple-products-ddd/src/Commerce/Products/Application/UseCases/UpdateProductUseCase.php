<?php

namespace Src\Commerce\Products\Application\UseCases;

use InvalidArgumentException;
use Src\Commerce\Products\Domain\Models\Product;
use Src\Commerce\Products\Domain\Repositories\ProductRepositoryInterface;
use Src\Commerce\Products\Domain\ValueObjects\Products\ProductDescription;
use Src\Commerce\Products\Domain\ValueObjects\Products\ProductName;

final class UpdateProductUseCase
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Executes the use case to update a product.
     *
     * @param string $productId The ID of the product to be updated.
     * @param string|null $newName The new name for the product, or null if not updating the name.
     * @param string|null $newDescription The new description for the product, or null if not updating the description.
     * @return void
     * @throws InvalidArgumentException If the input parameters are invalid.
     */
    public function execute(
        string $productId,
        ?string $newName,
        ?string $newDescription,
    ): void {
        if ($newName === null && $newDescription === null) {
            throw new \InvalidArgumentException('At least one field must be provided');
        }

        $product = $this->productRepository->findById($productId);
        if (!$product) {
            throw new \InvalidArgumentException("Product with ID $productId not found");
        }

        if ($newName !== null) {
            if (empty($newName)) {
                throw new InvalidArgumentException('Name cannot be empty if provided.');
            }
            $product->updateName(new ProductName($newName));
        }

        if ($newDescription !== null) {
            if (empty($newDescription)) {
                throw new InvalidArgumentException('Description cannot be empty if provided.');
            }
            $product->updateDescription(new ProductDescription($newDescription));
        }

        $this->productRepository->update($product);
    }
}