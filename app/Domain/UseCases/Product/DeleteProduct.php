<?php

namespace App\Domain\UseCases\Product;

use App\Domain\Ports\ProductRepositoryInterface;

class DeleteProduct
{
    public function __construct(private ProductRepositoryInterface $repository) {}

    public function execute(int $id): void
    {
        $product = $this->repository->findById($id);

        if ($product === null) {
            throw new \Exception('Product not found');
        }

        $this->repository->delete($id);
    }
}
