<?php

namespace App\Features\Order\Domain\UseCases;

use App\Features\Order\Domain\Entities\Order;
use App\Features\User\Domain\Entities\User;
use App\Features\Order\Domain\Ports\OrderUserRepositoryInterface;
use App\Features\Product\Domain\Ports\ProductRepositoryInterface;

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
