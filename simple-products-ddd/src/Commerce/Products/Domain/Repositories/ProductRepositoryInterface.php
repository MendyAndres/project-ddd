<?php

declare(strict_types=1);

namespace Src\Commerce\Products\Domain\Repositories;

use Src\Commerce\Products\Domain\Models\Product;

interface ProductRepositoryInterface
{
    public function save(Product $product): void;
    public function findById(string $id): ?Product;
    public function findAll(): array;
    public function update(Product $product): void;
    public function delete(string $id): void;

}