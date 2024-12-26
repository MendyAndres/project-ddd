<?php

declare(strict_types=1);

namespace Src\Commerce\Products\Domain\ValueObjects\Products;

use InvalidArgumentException;

final class ProductDescription
{
    private string $value;

    public function __construct(string $description)
    {
        $this->validate($description);
        $this->value = $description;
    }

    private function validate(string $description): void
    {
        if (empty($description)) {
            throw new InvalidArgumentException(
                sprintf('<%s> does not allow the empty description.', static::class)
            );
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}