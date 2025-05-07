<?php

namespace App\Features\Order\Domain\UseCases;

use App\Features\Order\Domain\Entities\Order;
use App\Features\Order\Domain\Ports\OrderRepositoryInterface;
use App\Features\Product\Domain\Ports\ProductRepositoryInterface;
use App\Features\User\Domain\Entities\User;

class CreateOrder
{
    public function __construct(
        private OrderRepositoryInterface $orderUserRepository,
        private ProductRepositoryInterface $productRepository,

    ) {}

    public function execute(User $user, array $products): Order
    {
        $order = new Order($user);

        foreach ($products as $item) {
            $id = $item['id'];
            $quantity = $item['quantity'];

            $product = $this->productRepository->findById($id);

            $order->addProduct($product, $quantity);
        }

        return $this->orderUserRepository->save($order);
    }
}
