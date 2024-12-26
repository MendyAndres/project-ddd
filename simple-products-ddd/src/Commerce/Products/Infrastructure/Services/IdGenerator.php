<?php

declare(strict_types=1);

namespace Src\Commerce\Products\Infrastructure\Services;

use Src\Commerce\Products\Domain\Services\IdGeneratorInterface;
use Ramsey\Uuid\Uuid;

class IdGenerator implements IdGeneratorInterface
{
    public function generateId(): string
    {
        return Uuid::uuid4()->toString();
    }
}