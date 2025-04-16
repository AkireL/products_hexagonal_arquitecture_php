<?php

namespace App\Features\User\Domain\Ports;

use App\Features\User\Domain\Entities\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function findById(int $id): ?User;

    public function findByEmail(string $email): ?User;

    public function delete(int $id): void;

    public function update(User $user): void;
}
