<?php

namespace App\Http\Controllers;

use App\Domain\Entities\Order;
use App\Domain\UseCases\Order\CreateOrder;
use App\Http\Requests\OrderRequest;
use App\Infraestructure\Persistence\EloquentOrderUserRepository;
use App\Infraestructure\Persistence\EloquentProductRepository;
use App\Infraestructure\Persistence\EloquentUserRepository;

class OrderUserController extends Controller
{
    public function store(OrderRequest $request)
    {
        $data = $request->validated();
        $userRepository = new EloquentUserRepository;

        $useCase = new CreateOrder(new EloquentOrderUserRepository, new EloquentProductRepository);

        $userId = $data['user_id'];
        $productsToSave = $data['products'];

        $user = $userRepository->findById($userId);

        $useCase->execute($user, $productsToSave);

        return response()->json([
            'message' => 'Order created successfully',
        ]);
    }
}


