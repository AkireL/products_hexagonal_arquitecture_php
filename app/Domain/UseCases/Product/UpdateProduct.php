<?php

namespace App\Domain\UseCases\Product;

use App\Domain\Entities\Product;
use App\Domain\Ports\ProductRepositoryInterface;

class UpdateProduct
{
    public function __construct(private ProductRepositoryInterface $repository) {}

    public function execute(Product $product): void
    {
        $product = $this->repository->findById($product->getId());

        if ($product === null) {
            throw new \Exception('Product not found');
        }

        $this->repository->update($product);
    }
}
