<?php

namespace App\Domain\UseCases\Order;

use App\Domain\Entities\Order;
use App\Domain\Ports\OrderUserRepositoryInterface;
use App\Domain\Ports\UserRepositoryInterface;

class RetrieveOrder
{
    public function __construct(
        private OrderUserRepositoryInterface $orderUserRepository,
        private UserRepositoryInterface $userRepository,
    ) {}

    public function execute($userId, int $orderId): ?Order
    {
        $user = $this->userRepository->findById($userId);
        $order = $this->orderUserRepository->findById($user, $orderId);

        return $order;
    }
}
