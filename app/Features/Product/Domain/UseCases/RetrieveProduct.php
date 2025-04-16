<?php

namespace App\Features\Product\Domain\UseCases;

use App\Features\Product\Domain\Entities\Product;
use App\Features\Product\Domain\Ports\ProductRepositoryInterface;

class RetrieveProduct
{
    public function __construct(private ProductRepositoryInterface $repository) {}

    public function execute(int $id): Product
    {
        $product = $this->repository->findById($id);

        if ($product === null) {
            throw new \Exception('Product not found');
        }

        return $product;
    }
}
