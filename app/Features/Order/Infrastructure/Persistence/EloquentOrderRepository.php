<?php

namespace App\Features\Order\Infrastructure\Persistence;

use App\Features\Order\Domain\Entities\Order as OrderEntity;
use App\Features\Order\Domain\Ports\OrderRepositoryInterface;
use App\Features\Product\Domain\Entities\Product as ProductEntity;
use App\Features\User\Domain\Entities\User as UserEntity;
use App\Models\Order as OrderModel;

class EloquentOrderRepository implements OrderRepositoryInterface
{
    public function list(int $userId): array
    {
        return [];
    }

    public function save(OrderEntity $order): OrderEntity
    {
        $model = OrderModel::create([
            'user_id' => $order->getUser()->getId(),
        ]);

        $order->setId($model->getKey());

        if (count($order->getProducts()) <= 0) {
            $order->setProducts([]);

            return $order;
        }

        foreach ($order->getProducts() as $key => $product) {
            $model->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'total_price' => $product['total_price'],
                'product_description' => $product['description'],
                'product_unit_price' => $product['unit_price'],
            ]);
        }

        return $this->findById($order->getUser(), $model->getKey());
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
                'product_id' => $product->id,
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

    public function updateProduct(OrderEntity $order, ProductEntity $product): void {}
}
