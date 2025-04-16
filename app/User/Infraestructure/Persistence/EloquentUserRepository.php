<?php

namespace App\User\Infraestructure\Persistence;

use App\User\Domain\Entities\User as UserDomain;
use App\Models\User;
use App\User\Domain\Ports\UserRepositoryInterface;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function save(UserDomain $user): void
    {
        User::create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
        ]);
    }

    public function findById(int $id): ?UserDomain
    {
        $user = User::find($id);
        if (! $user) {
            return null;
        }

        return new UserDomain($user->id, $user->name, $user->email, $user->password);
    }

    public function findByEmail(string $email): ?UserDomain
    {
        $user = User::where('email', $email)->first();

        if (! $user) {
            return null;
        }

        return new UserDomain($user->id, $user->name, $user->email, $user->password);
    }

    public function delete(int $id): void
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
        }
    }

    public function update(UserDomain $userDomain): void
    {
        $user = User::find($userDomain->getId());

        if ($user) {
            $user->update([
                'name' => $userDomain->getName(),
                'email' => $userDomain->getEmail(),
                'password' => $userDomain->getPassword(),
            ]);
        }
    }
}
