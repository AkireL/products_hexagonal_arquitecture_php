<?php

namespace App\Order\Domain\UseCases;

use App\Order\Domain\Entities\Order;
use App\User\Domain\Entities\User;
use App\Order\Domain\Ports\OrderUserRepositoryInterface;
use App\Product\Domain\Ports\ProductRepositoryInterface;

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
