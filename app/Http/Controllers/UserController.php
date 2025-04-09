<?php

namespace App\Http\Controllers;

use App\Domain\UseCases\User\CreateUser;
use App\Domain\UseCases\User\DeleteUser;
use App\Domain\UseCases\User\UpdateUser;
use App\Http\Requests\UserRequest;
use App\Infraestructure\Persistence\EloquentUserRepository;
use App\Models\User;
use Illuminate\Http\Request;

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

    public function update(Request $request, User $user)
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
