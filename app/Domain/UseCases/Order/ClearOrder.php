<?php

namespace App\Domain\UseCases\Order;

use App\Domain\Ports\OrderUserRepositoryInterface;
use App\Domain\Ports\UserRepositoryInterface;

class RemoveProducts
{
    public function __construct(private OrderUserRepositoryInterface $orderUserRepository, private UserRepositoryInterface $userRepository,
    )
    {}

    public function execute(int $orderId): void
    {
        $this->orderUserRepository->clear($orderId);
    }
}
