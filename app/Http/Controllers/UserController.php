<?php

namespace App\Http\Controllers;

use App\Features\User\Domain\UseCases\CreateUser;
use App\Features\User\Domain\UseCases\DeleteUser;
use App\Features\User\Domain\UseCases\UpdateUser;
use App\Features\User\Infrastructure\Persistence\EloquentUserRepository;
use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function store(UserRequest $request)
    {
        $useCase = new CreateUser(new EloquentUserRepository);
        $useCase->execute($request->name, $request->email, $request->password);

        return response()->json([
            'message' => 'User created successfully',
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        $useCase = new UpdateUser(new EloquentUserRepository);
        $useCase->execute($user->id, $request->name, $request->email, $request->password);

        return response()->json([
            'message' => 'User updated successfully',
        ]);
    }

    public function destroy(User $user)
    {
        $useCase = new DeleteUser(new EloquentUserRepository);
        $useCase->execute($user->id);

        return response()->json([
            'message' => 'User deleted successfully',
        ]);
    }
}
