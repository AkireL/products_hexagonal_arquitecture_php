<?php

namespace App\Http\Controllers;

use App\Features\Order\Domain\UseCases\ClearOrder;
use App\Features\Order\Domain\UseCases\CreateOrder;
use App\Features\Order\Domain\UseCases\RetrieveOrder;
use App\Features\Order\Infrastructure\Persistence\EloquentOrderRepository;
use App\Features\Product\Infrastructure\Persistence\EloquentProductRepository;
use App\Features\User\Infrastructure\Persistence\EloquentUserRepository;
use App\Http\Requests\OrderRequest;
use App\Models\Order;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        $useCase = new RetrieveOrder(new EloquentOrderRepository, new EloquentUserRepository);
        $order = $useCase->execute($order->user_id, $order->id);

        return response()->json([
            'data' => [
                'id' => $order->getId(),
                'user_id' => $order->getUser()->getId(),
                'products' => $order->getProducts(),
            ]
        ]);
    }

    public function store(OrderRequest $request)
    {
        $data = $request->validated();
        $userRepository = new EloquentUserRepository;

        $useCase = new CreateOrder(new EloquentOrderRepository, new EloquentProductRepository);

        $userId = $data['user_id'];
        $productsToSave = $data['products'];

        $user = $userRepository->findById($userId);

        $order = $useCase->execute($user, $productsToSave);

        return response()->json([
            'data' => [
                'id' => $order->getId(),
                'user_id' => $order->getUser()->getId(),
                'products' => $order->getProducts(),
            ]
        ], 201);
    }

    public function clear(Order $order)
    {
        $useCase = new ClearOrder(
            new EloquentOrderRepository,
            new EloquentUserRepository
        );

        $useCase->execute($order->id);

        return response()->json([
            'message' => 'Order cleared successfully',
        ]);
    }
}
