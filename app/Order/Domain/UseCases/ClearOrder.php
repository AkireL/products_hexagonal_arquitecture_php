<?php

namespace App\Order\Domain\UseCases;

use App\Order\Domain\Ports\OrderUserRepositoryInterface;
use App\User\Domain\Ports\UserRepositoryInterface;

class ClearOrder
{
    public function __construct(
        private OrderUserRepositoryInterface $orderUserRepository,
        private UserRepositoryInterface $userRepository,
    )
    {}

    public function execute(int $orderId): void
    {
        $this->orderUserRepository->clear($orderId);
    }
}
