<?php

namespace App\Domain\Entities;

class Order
{
    private int $id;
    private array $products;
    private User $user;

    public function __construct(User $user, int $id = 0)
    {
        $this->id = $id;
        $this->user = $user;
        $this->products = [];
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function addProduct(Product $product, float $quantity)
    {
        if ($product->getStock() <= $quantity){return null;}

        foreach($this->products as $key => $item) {
            if ($item->getId() == $product->getId()){
                $this->products[$key]['quantity'] += $quantity;
                return;
            }
        }

        $this->products[] = [
            'id' => $product['id'],
            'quantity' => $product['quantity'],
            'total_price' => $product['unit_price'] * $product['quantity'],
            'description' => $product['description'],
            'unit_price' => $product['unit_price'],
        ];
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
