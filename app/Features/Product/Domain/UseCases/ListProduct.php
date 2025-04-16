<?php

namespace App\Features\Product\Domain\UseCases;

use App\Features\Product\Domain\Ports\ProductRepositoryInterface;

class ListProduct
{
    public function __construct(private ProductRepositoryInterface $repository) {}

    public function execute(): array
    {
        return $this->repository->list();
    }
}
