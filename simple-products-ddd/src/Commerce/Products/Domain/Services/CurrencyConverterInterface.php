<?php

declare(strict_types=1);

namespace Src\Commerce\Products\Domain\Services;

use Src\Commerce\Products\Domain\ValueObjects\Products\ProductPrice;

interface CurrencyConverterInterface
{
    public function convertToDollars(ProductPrice $price): float;
}