<?php

namespace App\Domain\UseCases\Product;
use App\Domain\Ports\ProductRepositoryInterface;

class ListProduct
{
    public function __construct(private ProductRepositoryInterface $repository) {}

    public function execute(): array
    {
        return $this->repository->list();
    }
}
