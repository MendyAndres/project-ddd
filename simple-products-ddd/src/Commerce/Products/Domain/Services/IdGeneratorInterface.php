<?php

declare(strict_types=1);

namespace Src\Commerce\Products\Domain\Services;

interface IdGeneratorInterface
{
    public function generateId(): string;
}

