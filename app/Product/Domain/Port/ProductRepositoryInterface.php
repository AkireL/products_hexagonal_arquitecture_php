<?php

namespace App\Product\Domain\Ports;

use App\Product\Domain\Entities\Product;

interface ProductRepositoryInterface
{
    public function list(): array;

    public function save(Product $product): void;

    public function findById(int $id): ?Product;

    public function findByName(string $name): ?Product;

    public function delete(int $id): void;

    public function update(Product $product): void;
}
