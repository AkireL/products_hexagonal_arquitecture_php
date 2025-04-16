<?php

namespace App\Product\Domain\UseCases;

use App\Product\Domain\Entities\Product;
use App\Product\Domain\Ports\ProductRepositoryInterface;

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
