<?php

declare(strict_types=1);

namespace Src\Commerce\Products\Domain\ValueObjects\Products;

use InvalidArgumentException;

final class ProductPrice
{
    private float $value;

    public function __construct(float $price)
    {
        $this->validate($price);
        $this->value = $price;
    }

    private function validate(float $price): void
    {
        if ($price < 0) {
            throw new InvalidArgumentException(
                sprintf('<%s> does not allow negative prices: <%s>.', static::class, $price)
            );
        }
    }

    public function value(): float
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public function equals(ProductPrice $price): bool
    {
        return $this->value() === $price->value();
    }
}

