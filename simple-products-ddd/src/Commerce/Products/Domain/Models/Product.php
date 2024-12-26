<?php

declare(strict_types=1);

namespace Src\Commerce\Products\Domain\Models;

use Src\Commerce\Products\Domain\ValueObjects\Products\ProductId;
use Src\Commerce\Products\Domain\ValueObjects\Products\ProductName;
use Src\Commerce\Products\Domain\ValueObjects\Products\ProductDescription;
use Src\Commerce\Products\Domain\ValueObjects\Products\ProductPrice;

final class Product
{
    private ProductId $id;
    private ProductName $name;
    private ProductDescription $description;
    private ProductPrice $price;


    public function __construct(
        ProductId $id,
        ProductName $name,
        ProductDescription $description,
        ProductPrice $price,
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        }

    public function getId(): ProductId
    {
        return $this->id;
    }

    public function getName(): ProductName
    {
        return $this->name;
    }

    public function getDescription(): ProductDescription
    {
        return $this->description;
    }

    public function getPrice(): ProductPrice
    {
        return $this->price;
    }

    public function updatePrice(ProductPrice $price): void
    {
        $this->price = $price;
    }

    public function updateDescription(ProductDescription $description): void
    {
        $this->description = $description;
    }

    public function updateName(ProductName $name): void
    {
        $this->name = $name;
    }
}

