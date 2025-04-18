<?php

namespace App\Http\Controllers;

use App\Features\Product\Domain\Entities\Product as ProductDomain;
use App\Features\Product\Domain\UseCases\CreateProduct;
use App\Features\Product\Domain\UseCases\DeleteProduct;
use App\Features\Product\Domain\UseCases\ListProduct;
use App\Features\Product\Domain\UseCases\RetrieveProduct;
use App\Features\Product\Domain\UseCases\UpdateProduct;
use App\Features\Product\Infraestructure\Persistence\EloquentProductRepository;
use App\Http\Requests\ProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $useCase = new ListProduct(new EloquentProductRepository);
        $products = $useCase->execute();

        return response()->json($products);
    }

    public function show(Product $product)
    {
        $useCase = new RetrieveProduct(new EloquentProductRepository);
        $product = $useCase->execute($product->id);

        return response()->json([
            'id' => $product->getId(),
            'name' => $product->getName(),
            'unit_price' => $product->getUnitPrice(),
            'stock' => $product->getStock(),
            'description' => $product->getDescription(),
        ]);
    }

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
                $data['unit_price'],
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
