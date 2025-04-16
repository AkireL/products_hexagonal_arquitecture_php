<?php

namespace App\Features\User\Domain\UseCases;

use App\Features\User\Domain\Entities\User;
use App\Features\User\Domain\Ports\UserRepositoryInterface;

class CreateUser
{
    public function __construct(private UserRepositoryInterface $repository) {}

    public function execute(string $name, string $email, string $password): void
    {
        $user = new User(0, $name, $email, $password);

        $this->repository->save($user);
    }
}
