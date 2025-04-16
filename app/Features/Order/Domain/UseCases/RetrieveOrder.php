<?php

namespace App\Features\Order\Domain\UseCases;

use App\Features\Order\Domain\Entities\Order;
use App\Features\Order\Domain\Ports\OrderUserRepositoryInterface;
use App\Features\User\Domain\Ports\UserRepositoryInterface;

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
