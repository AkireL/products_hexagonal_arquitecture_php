<?php

namespace App\Http\Controllers;

use App\Domain\UseCases\Order\CreateOrder;
use App\Domain\UseCases\Order\RemoveProducts;
use App\Domain\UseCases\Order\RetrieveOrder;
use App\Http\Requests\OrderRequest;
use App\Infraestructure\Persistence\EloquentOrderUserRepository;
use App\Infraestructure\Persistence\EloquentProductRepository;
use App\Infraestructure\Persistence\EloquentUserRepository;
use App\Models\Order;

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
        $useCase = new RemoveProducts(
            new EloquentOrderUserRepository,
            new EloquentUserRepository
        );

        $useCase->execute($order->id);

        return response()->json([
            'message' => 'Order cleared successfully',
        ]);
    }
}


