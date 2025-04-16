<?php

namespace App\Features\Order\Domain\UseCases;

use App\Features\Order\Domain\Ports\OrderRepositoryInterface;
use App\Features\User\Domain\Ports\UserRepositoryInterface;

class ClearOrder
{
    public function __construct(
        private OrderRepositoryInterface $orderUserRepository,
        private UserRepositoryInterface $userRepository,
    ) {}

    public function execute(int $orderId): void
    {
        $this->orderUserRepository->clear($orderId);
    }
}
