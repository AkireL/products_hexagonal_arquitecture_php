<?php

namespace App\Http\Controllers;

use App\Domain\Entities\Product as ProductDomain;
use App\Domain\UseCases\Product\CreateProduct;
use App\Domain\UseCases\Product\DeleteProduct;
use App\Domain\UseCases\Product\UpdateProduct;
use App\Http\Requests\ProductRequest;
use App\Infraestructure\Persistence\EloquentProductRepository;
use App\Models\Product;

class ProductController extends Controller
{
    public function store(ProductRequest $request)
    {
        $data = $request->validated();

        $useCase = new CreateProduct(new EloquentProductRepository);
        $useCase->execute(
            $data['name'],
            $data['unit_price'],
            $data['stock'] ?? 0,
            $data['description'] ?? null
        );
        return response()->json(['message' => 'Product created successfully'], 201);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $useCase = new UpdateProduct(new EloquentProductRepository);
        $useCase->execute(
            new ProductDomain(
                $product->id,
                $data['name'],
                $data['price'],
                $data['stock'] ?? 0,
                $data['description'] ?? null
            )
        );
        return response()->json(['message' => 'Product updated successfully']);
    }

    public function destroy(Product $product)
    {
        $useCase = new DeleteProduct(new EloquentProductRepository);
        $useCase->execute($product->id);
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
