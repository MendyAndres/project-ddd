<?php

declare(strict_types=1);

namespace Src\Commerce\Products\Application\UseCases;

use Src\Commerce\Products\Domain\Repositories\ProductRepositoryInterface;

final class ListProductsUseCase
{
    private ProductRepositoryInterface $repository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->repository = $productRepository;
    }

    public function execute(): array
    {
        return $this->repository->findAll();
    }
}