<?php

namespace App\Product\Domain\UseCases;

use App\Product\Domain\Ports\ProductRepositoryInterface;

class ListProduct
{
    public function __construct(private ProductRepositoryInterface $repository) {}

    public function execute(): array
    {
        return $this->repository->list();
    }
}
