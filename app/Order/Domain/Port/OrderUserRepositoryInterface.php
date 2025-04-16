<?php

namespace App\Order\Domain\Ports;

use App\Order\Domain\Entities\Order;
use App\Product\Domain\Entities\Product;
use App\User\Domain\Entities\User;

interface OrderUserRepositoryInterface
{
    public function list(int $userId): array;

    public function save(Order $order): void;

    public function findById(User $user, int $orderId): ?Order;

    public function clear(int $orderId): void;

    public function addProduct(Order $order, Product $product): void;

    public function getProducts(Order $order): array;

    public function updateProduct(Order $order, Product $product): void;
}
