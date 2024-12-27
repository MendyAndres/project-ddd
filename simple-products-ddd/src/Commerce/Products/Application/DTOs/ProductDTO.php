<?php
declare(strict_types=1);

namespace Src\Commerce\Products\Application\DTOs;

final class ProductDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public float $price,
    ) {}

    /**
     * Creates a ProductDTO from a Product entity.
     *
     * This static method takes a Product entity as input and returns a new instance
     * of ProductDTO with the corresponding values from the Product entity.
     *
     * @param Product $product The product entity to convert.
     * @return self A new instance of ProductDTO.
     */
    public static function fromProduct($product): self
    {
        return new self(
            $product->id()->value(),
            $product->name()->value(),
            $product->description()->value(),
            $product->price()->value(),
        );
    }
}