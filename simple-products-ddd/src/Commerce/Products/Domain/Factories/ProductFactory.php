<?php

declare(strict_types=1);

namespace Src\Commerce\Products\Domain\Factories;

use Src\Commerce\Products\Domain\Models\Product;
use Src\Commerce\Products\Domain\ValueObjects\Products\ProductDescription;
use Src\Commerce\Products\Domain\ValueObjects\Products\ProductId;
use Src\Commerce\Products\Domain\ValueObjects\Products\ProductName;
use Src\Commerce\Products\Domain\ValueObjects\Products\ProductPrice;

final class ProductFactory
{

    public function create(
        string $id,
        string $name,
        string $description,
        float $price,
    ): Product
    {
        $productId = new ProductId($id);
        $productName = new ProductName($name);
        $productDescription = new ProductDescription($description);
        $productPrice = new ProductPrice($price);

        return new Product(
            $productId,
            $productName,
            $productDescription,
            $productPrice,
        );
    }
}