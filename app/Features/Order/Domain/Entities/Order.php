<?php

namespace App\Features\Order\Domain\Entities;

use App\Features\Product\Domain\Entities\Product;
use App\Features\User\Domain\Entities\User;

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
        if ($product->getStock() < $quantity) {
            return null;
        }

        foreach ($this->products as $key => $item) {
            if ($item['id'] == $product->getId()) {
                $this->products[$key]['quantity'] += $quantity;

                return;
            }
        }

        $this->products[] = [
            'id' => $product->getId(),
            'quantity' => $quantity,
            'total_price' => $product->getUnitPrice() * $quantity,
            'description' => $product->getDescription(),
            'unit_price' => $product->getUnitPrice(),
        ];
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function setProducts(array $products): void
    {
        $this->products = $products;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
}
