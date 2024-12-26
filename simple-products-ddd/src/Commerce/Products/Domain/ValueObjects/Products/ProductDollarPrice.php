<?php

declare(strict_types=1);

namespace Src\Commerce\Products\Domain\ValueObjects\Products;

use InvalidArgumentException;

final class ProductDollarPrice
{
    private float $value;

    public function __construct(float $priceInDollars)
    {
        $this->validate($priceInDollars);
        $this->value = $priceInDollars;
    }

    private function validate($float): void
    {
        if ($float < 0) {
            throw new InvalidArgumentException(
                sprintf('<%s> does not allow the negative price.', static::class)
            );
        }
    }
    public function value(): float
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return '$' . number_format($this->value, 2, '.','') . ' USD';
    }

    public function equals(ProductDollarPrice $price): bool
    {
        return $this->value() === $price->value();
    }
}