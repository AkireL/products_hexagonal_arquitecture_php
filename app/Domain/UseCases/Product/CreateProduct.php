<?php

namespace App\Domain\UseCases\Product;

use App\Domain\Entities\Product;
use App\Domain\Ports\ProductRepositoryInterface;

class CreateProduct
{
    public function __construct(private ProductRepositoryInterface $repository) {}

    public function execute(string $name, float $unitPrice, int $stock = 0, ?string $description = null): void
    {
        $user = new Product(0, $name, $unitPrice, $stock, $description);

        $this->repository->save($user);
    }
}
