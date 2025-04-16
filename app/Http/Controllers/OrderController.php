<?php

namespace App\Http\Controllers;

use App\Features\Order\Domain\UseCases\ClearOrder;
use App\Features\Order\Domain\UseCases\CreateOrder;
use App\Features\Order\Domain\UseCases\RetrieveOrder;
use App\Features\Order\Infraestructure\Persistence\EloquentOrderRepository;
use App\Features\Product\Infraestructure\Persistence\EloquentProductRepository;
use App\Features\User\Infraestructure\Persistence\EloquentUserRepository;
use App\Http\Requests\OrderRequest;
use App\Models\Order;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        $useCase = new RetrieveOrder(new EloquentOrderRepository, new EloquentUserRepository);
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

        $useCase = new CreateOrder(new EloquentOrderRepository, new EloquentProductRepository);

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
            new EloquentOrderRepository,
            new EloquentUserRepository
        );

        $useCase->execute($order->id);

        return response()->json([
            'message' => 'Order cleared successfully',
        ]);
    }
}
