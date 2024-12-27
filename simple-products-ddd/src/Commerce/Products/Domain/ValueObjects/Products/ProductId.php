<?php

declare(strict_types=1);

namespace Src\Commerce\Products\Domain\ValueObjects\Products;

use InvalidArgumentException;

final class ProductId
{
    private string $id;

    public function __construct(string $id)
    {
        $this->validate($id);
        $this->id = $id;
    }

    private function validate(string $id): void
    {
        if (!preg_match(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
            $id
        )) {
            throw new InvalidArgumentException(sprintf('El ID "%s" no es un UUID válido.', $id));
        }
    }

    public function value(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public function equals(ProductId $id): bool
    {
        return $this->value() === $id->value();
    }
}