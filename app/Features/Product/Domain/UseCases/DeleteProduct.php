<?php

namespace App\Features\Product\Domain\UseCases;

use App\Features\Product\Domain\Ports\ProductRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DeleteProduct
{
    public function __construct(private ProductRepositoryInterface $repository) {}

    public function execute(int $id): void
    {
        $product = $this->repository->findById($id);

        if ($product === null) {
            throw new HttpException(404, 'Product not found');
        }

        $this->repository->delete($id);
    }
}
