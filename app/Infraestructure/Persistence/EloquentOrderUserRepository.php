<?php

namespace App\Infraestructure\Persistence;

use App\Domain\Entities\Order as OrderEntity;
use App\Domain\Entities\Product as ProductEntity;
use App\Domain\Entities\User as UserEntity;
use App\Domain\Ports\OrderUserRepositoryInterface;
use App\Models\Order as OrderModel;

class EloquentOrderUserRepository implements OrderUserRepositoryInterface
{
    public function list(int $userId): array
    {
        return [];
    }

    public function save(OrderEntity $order) : void
    {
        $model = OrderModel::create([
            'user_id' => $order->getUser()->getId()
        ]);

        if (count($order->getProducts()) <=0) {
            return;
        }

        foreach ($order->getProducts() as $product) {
            $model->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'total_price' => $product['total_price'],
                'product_description' => $product['description'],
                'product_unit_price' => $product['unit_price'],
            ]);
        }
    }

    public function findById(UserEntity $user, int $orderId): ?OrderEntity
    {
        $order = OrderModel::where('id', $orderId)
            ->where('user_id', $user->getId())
            ->first();

        if (! $order) {
            return null;
        }

        $orderEntity = new OrderEntity($user, $order->id);

        $products = [];

        foreach ($order->products as $product) {
            $products[] = [
                'id' => $product->pivot->id,
                'quantity' => $product->pivot->quantity,
                'total_price' => $product->pivot->total_price,
                'description' => $product->pivot->product_description,
                'unit_price' => $product->pivot->product_unit_price,
            ];
        }
        $orderEntity->setProducts($products);
        return $orderEntity;
    }

    public function clear(int $orderId): void
    {
        $order = OrderModel::find($orderId);

        if ($order) {
            $order->products()->detach();
        }
    }

    public function addProduct(OrderEntity $order, ProductEntity $product): void
    {
        $orderModel = OrderModel::find($order->getId());

        if ($orderModel && $orderModel->products->contains($product->getId())) {
            $existProduct = $orderModel->products->find($product->getId());

            $orderModel
                ->products()
                ->updateExistingPivot(
                    $product->getId(), [
                        'quantity' => $existProduct->pivot->quantity + 1,
                        'total_price' => $existProduct->pivot->total_price + $product->getUnitPrice(),
                    ]
                );
            return;
        }
        $orderModel->products()->attach($product->getId(), [
            'quantity' => 1,
            'total_price' => $product->getUnitPrice(),
            'description' => $product->getDescription(),
            'unit_price' => $product->getUnitPrice(),
        ]);
    }

    public function getProducts(OrderEntity $order): array
    {
        $orderModel = OrderModel::find($order->getId());
        $productsToSend = [];

        if (! $orderModel) {
            return [];
        }
        $products = $orderModel->products;

        foreach ($products as $productOrder) {
            $productsToSend[] = [
                'id' => $productOrder->id,
                'quantity' => $productOrder->pivot->quantity,
                'total_price' => $productOrder->pivot->total_price,
                'description' => $productOrder->pivot->description,
                'unit_price' => $productOrder->pivot->unit_price,
            ];
        }
        return $productsToSend;
    }

    public function updateProduct(OrderEntity $order, ProductEntity $product): void
    {

    }
}
