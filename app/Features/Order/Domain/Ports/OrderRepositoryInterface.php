<?php

namespace App\Features\Order\Domain\Ports;

use App\Features\Order\Domain\Entities\Order;
use App\Features\Product\Domain\Entities\Product;
use App\Features\User\Domain\Entities\User;

interface OrderRepositoryInterface
{
    public function list(int $userId): array;

    public function save(Order $order): Order;

    public function findById(User $user, int $orderId): ?Order;

    public function clear(int $orderId): void;

    public function addProduct(Order $order, Product $product): void;

    public function getProducts(Order $order): array;

    public function updateProduct(Order $order, Product $product): void;
}
