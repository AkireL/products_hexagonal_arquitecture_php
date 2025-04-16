<?php

namespace App\Domain\UseCases\Order;

use App\Domain\Entities\User;
use App\Domain\Ports\UserRepositoryInterface;

class RetrieveOrder
{
    public function __construct(
        private \App\Domain\Ports\OrderUserRepositoryInterface $orderUserRepository,
        private UserRepositoryInterface $userRepository,
    ) {}

    public function execute(User $user, int $orderId): ?\App\Domain\Entities\Order
    {
        return $this->orderUserRepository->findById($user, $orderId);
    }
}
