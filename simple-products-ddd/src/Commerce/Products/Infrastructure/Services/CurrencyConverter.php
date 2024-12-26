<?php

declare(strict_types=1);

namespace Src\Commerce\Products\Infrastructure\Services;

use Src\Commerce\Products\Domain\Services\CurrencyConverterInterface;
use Src\Commerce\Products\Domain\ValueObjects\Products\ProductDollarPrice;
use Src\Commerce\Products\Domain\ValueObjects\Products\ProductPrice;

class CurrencyConverter implements CurrencyConverterInterface
{
    private float $exchangeRate;

    public function __construct(float $exchangeRate)
    {
        $this->exchangeRate = $exchangeRate;
    }

    public function convertToDollars(ProductPrice $price): float
    {
        $dollarPrice = $price->value() / $this->exchangeRate;
        return new $dollarPrice;
    }
}