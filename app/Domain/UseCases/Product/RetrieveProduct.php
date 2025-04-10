<?php

namespace App\Domain\UseCases\Product;

use App\Domain\Entities\Product;
use App\Domain\Ports\ProductRepositoryInterface;

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
