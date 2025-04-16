<?php

namespace App\User\Domain\UseCases;

use App\User\Domain\Entities\User;
use App\User\Domain\Ports\UserRepositoryInterface;

class CreateUser
{
    public function __construct(private UserRepositoryInterface $repository) {}

    public function execute(string $name, string $email, string $password): void
    {
        $user = new User(0, $name, $email, $password);

        $this->repository->save($user);
    }
}
