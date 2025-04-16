<?php

namespace App\Product\Domain\UseCases;

use App\Product\Domain\Entities\Product;
use App\Product\Domain\Ports\ProductRepositoryInterface;

class CreateProduct
{
    public function __construct(private ProductRepositoryInterface $repository) {}

    public function execute(string $name, float $unitPrice, int $stock = 0, ?string $description = null): void
    {
        $product = new Product(0, $name, $unitPrice, $stock, $description);

        $this->repository->save($product);
    }
}
