<?php

namespace App\Features\Product\Infraestructure\Persistence;

use App\Features\Product\Domain\Entities\Product as ProductDomain;
use App\Models\Product;
use App\Features\Product\Domain\Ports\ProductRepositoryInterface;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function save(ProductDomain $product): void
    {
        Product::create([
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'unit_price' => $product->getUnitPrice(),
            'stock' => $product->getStock(),
        ]);
    }

    public function findById(int $id): ?ProductDomain
    {
        $product = Product::find($id);

        if (! $product) {
            return null;
        }

        return new ProductDomain($product->id, $product->name, $product->unit_price, $product->stock, $product->description);
    }

    public function findByName(string $name): ?ProductDomain
    {
        $product = Product::where('name', $name)->first();

        if (! $product) {
            return null;
        }

        return new ProductDomain($product->id, $product->name, $product->unit_price, $product->stock, $product->description);
    }

    public function delete(int $id): void
    {
        Product::where('id', $id)->delete();
    }

    public function update(ProductDomain $productDomain): void
    {
        $product = Product::find($productDomain->getId());

        if ($product) {
            $product->update([
                'name' => $productDomain->getName(),
                'description' => $productDomain->getDescription(),
                'stock' => $productDomain->getStock(),
                'unit_price' => $productDomain->getUnitPrice(),
            ]);
        }
    }

    public function list(): array
    {
        return Product::all()->toArray();
    }
}
