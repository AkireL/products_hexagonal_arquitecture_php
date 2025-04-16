<?php

namespace App\Domain\Ports;

use App\Domain\Entities\Order;
use App\Domain\Entities\Product;
use App\Domain\Entities\ProductOrder;
use App\Domain\Entities\User;

interface OrderUserRepositoryInterface
{
    public function list(int $userId): array;

    public function save(Order $order): void;

    public function findById(User $user, int $orderId): ?Order;

    public function clear(int $orderId): void;

    public function remove(Order $order, Product $product): void;

    public function addProduct(Order $order, Product $product): void;

    public function getProduct(Order $order, int $productId): ?ProductOrder;

    public function getProducts(Order $order): array;

    public function updateProduct(Order $order, Product $product): void;

    public function updateOrder(Order $order): void;
}
