<?php

namespace App\Http\Controllers;

use App\Features\Product\Domain\Entities\Product as ProductDomain;
use App\Features\Product\Domain\UseCases\CreateProduct;
use App\Features\Product\Domain\UseCases\DeleteProduct;
use App\Features\Product\Domain\UseCases\ListProduct;
use App\Features\Product\Domain\UseCases\RetrieveProduct;
use App\Features\Product\Domain\UseCases\UpdateProduct;
use App\Http\Requests\ProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(ListProduct $useCase)
    {
        $products = $useCase->execute();

        return response()->json(['data' => $products]);
    }

    public function show(Product $product, RetrieveProduct $useCase)
    {
        $product = $useCase->execute($product->id);

        return response()->json(
            [
                'data' => [
                    'id' => $product->getId(),
                    'name' => $product->getName(),
                    'unit_price' => $product->getUnitPrice(),
                    'stock' => $product->getStock(),
                    'description' => $product->getDescription(),
                ],
            ]
        );
    }

    public function store(ProductRequest $request, CreateProduct $useCase)
    {
        $data = $request->validated();

        $useCase->execute(
            $data['name'],
            $data['unit_price'],
            $data['stock'] ?? 0,
            $data['description'] ?? null
        );

        return response()->json(['message' => 'Product created successfully'], 201);
    }

    public function update(ProductRequest $request, Product $product, UpdateProduct $useCase)
    {
        $data = $request->validated();

        $useCase->execute(
            new ProductDomain(
                $product->id,
                $data['name'],
                $data['unit_price'],
                $data['stock'] ?? 0,
                $data['description'] ?? null
            )
        );

        return response()->json(['message' => 'Product updated successfully']);
    }

    public function destroy(Product $product, DeleteProduct $useCase)
    {
        $useCase->execute($product->id);

        return response()->json(
            [
                'message' => 'Product deleted successfully',
            ],
            204
        );
    }
}
