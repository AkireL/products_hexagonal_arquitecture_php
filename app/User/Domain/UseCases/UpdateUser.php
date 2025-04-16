<?php

namespace App\User\Domain\UseCases;

use App\User\Domain\Entities\User;
use App\User\Domain\Ports\UserRepositoryInterface;
use Exception;

class UpdateUser
{
    public function __construct(private UserRepositoryInterface $repository) {}

    public function execute(int $id, ?string $name=null, ?string $email= null, ?string $password= null): void
    {
        $existingUser = $this->repository->findById($id);

        if (! $existingUser) {
            throw new Exception('User not found');
        }

        $user = new User($id, $name, $email, $password);
        $this->repository->update($user);
    }
}
