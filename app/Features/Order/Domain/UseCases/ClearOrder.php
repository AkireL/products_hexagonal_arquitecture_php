<?php

namespace App\Features\Order\Domain\UseCases;

use App\Features\Order\Domain\Ports\OrderUserRepositoryInterface;
use App\Features\User\Domain\Ports\UserRepositoryInterface;

class ClearOrder
{
    public function __construct(
        private OrderUserRepositoryInterface $orderUserRepository,
        private UserRepositoryInterface $userRepository,
    ) {}

    public function execute(int $orderId): void
    {
        $this->orderUserRepository->clear($orderId);
    }
}
