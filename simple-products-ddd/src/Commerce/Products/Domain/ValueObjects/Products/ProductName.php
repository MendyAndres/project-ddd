<?php

declare(strict_types=1);

namespace Src\Commerce\Products\Domain\ValueObjects\Products;
use InvalidArgumentException;

final class ProductName
{
    private string $value;

    public function __construct(string $name)
    {
        $this->validate($name);
        $this->value = $name;
    }

    private function validate(string $name): void
    {
        if (empty($name)) {
            throw new InvalidArgumentException(
                sprintf('<%s> does not allow the empty name.', static::class)
            );
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}