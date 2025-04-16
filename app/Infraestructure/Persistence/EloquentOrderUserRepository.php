<?php

namespace App\Infraestructure\Persistence;

use App\Domain\Entities\Order as OrderEntity;
use App\Domain\Entities\Product as ProductEntity;
use App\Domain\Entities\ProductOrder;
use App\Domain\Entities\User as UserEntity;
use App\Domain\Ports\OrderUserRepositoryInterface;
use App\Models\Order as OrderModel;

class EloquentOrderUserRepository implements OrderUserRepositoryInterface
{
    public function list(int $userId): array
    {
        return [];
    }

    public function updateOrder(OrderEntity $order): void
    {
        return;
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
            $model->products()->attach($product->id, [
                'quantity' => $product->quantity,
                'total_price' => $product->total_price,
                'description' => $product->description,
                'unit_price' => $product->unit_price,
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

        foreach ($order->getAllProducts() as $product) {
            $product = new ProductOrder(
                $product->id,
                $product->order_id,
                $product->product_id,
                $product->name,
                $product->quantity,
                $product->total_price,
                $product->product_description,
                $product->product_unit_price
            );

            $quantity = $product->getQuantity();
            $productE = new ProductEntity(
                $product->getId(),
                $product->getName(),
                $product->getUnitPrice(),
                $product->getStock(),
                $product->getDescription(),
            );
            $orderEntity->addProduct($productE, $quantity);
        }
        return $orderEntity;
    }

    public function clear(int $orderId): void
    {
        $order = OrderModel::find($orderId);

        if ($order) {
            $order->products()->detach();
        }
    }

    public function remove(OrderEntity $order, ProductEntity $product): void
    {
        $orderModel = OrderModel::find($order->getId());

        if ($orderModel && $orderModel->products->contains($product->getId())) {
            $hasProduct = $orderModel->products->find($product->getId());
            if ($hasProduct && $hasProduct->pivot->quantity > 1) {
                $orderModel->products()->updateExistingPivot($product->getId(), [
                    'quantity' => $hasProduct->pivot->quantity - 1,
                    'total_price' => $hasProduct->pivot->total_price - $product->getUnitPrice(),
                ]);
                return;
            }

            $orderModel->products()->detach($product->getId());
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

    public function getProduct(OrderEntity $order, int $productId): ?ProductOrder
    {
        $orderModel = OrderModel::find($order->getId());

        if ($orderModel && $orderModel->products->contains($productId)) {
            $productOrder = $orderModel->products->find($productId);
            if ($productOrder) {
                return new ProductOrder(
                    $productOrder->getId(),
                    $productOrder->quantity,
                    $productOrder->total_price,
                    $productOrder->product_description,
                    $productOrder->product_unit_price
                );
            }
        }

        return null;
    }

    public function getProducts(OrderEntity $order): array
    {
        return [];
    }

    public function updateProduct(OrderEntity $order, ProductEntity $product): void
    {

    }
}
