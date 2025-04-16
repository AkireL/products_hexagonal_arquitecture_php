<?php

namespace App\User\Domain\UseCases;

use App\User\Domain\Ports\UserRepositoryInterface;
use Exception;

class DeleteUser
{
    public function __construct(private UserRepositoryInterface $repository) {}

    public function execute(int $id): void
    {
        $existingUser = $this->repository->findById($id);

        if (! $existingUser) {
            throw new Exception('User not found');
        }

        $this->repository->delete($id);
    }
}
