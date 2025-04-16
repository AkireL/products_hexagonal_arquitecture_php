<?php

namespace App\Http\Controllers;

use App\Order\Domain\UseCases\CreateOrder;
use App\Order\Domain\UseCases\RetrieveOrder;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Order\Domain\UseCases\ClearOrder;
use App\Order\Infraestructure\Persistence\EloquentOrderUserRepository;
use App\Product\Infraestructure\Persistence\EloquentProductRepository;
use App\User\Infraestructure\Persistence\EloquentUserRepository;

class OrderUserController extends Controller
{
    public function show(Order $order)
    {
        $useCase = new RetrieveOrder(new EloquentOrderUserRepository, new EloquentUserRepository);
        $order = $useCase->execute($order->user_id, $order->id);

        return response()->json([
            'id' => $order->getId(),
            'user_id' => $order->getUser()->getId(),
            'products' => $order->getProducts(),
        ]);
    }

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

    public function clear(Order $order)
    {
        $useCase = new ClearOrder(
            new EloquentOrderUserRepository,
            new EloquentUserRepository
        );

        $useCase->execute($order->id);

        return response()->json([
            'message' => 'Order cleared successfully',
        ]);
    }
}


