<?php

namespace App\Domain\UseCases\Order;

use App\Domain\Entities\Order;
use App\Domain\Entities\User;
use App\Domain\Ports\OrderUserRepositoryInterface;
use App\Domain\Ports\ProductRepositoryInterface;

class CreateOrder
{
    public function __construct(
        private OrderUserRepositoryInterface $orderUserRepository,
        private ProductRepositoryInterface $productRepository,

        ) {}

    public function execute(User $user, array $products): void
    {
        $order = new Order($user);

        foreach($products as $item) {
            $id = $item['id'];
            $quantity = $item['quantity'];

            $product = $this->productRepository->findById($id);

            $order->addProduct($product, $quantity);
        }

        $this->orderUserRepository->save($order);
    }
}
