<?php

namespace App\Domain\Entities;

class ProductOrder
{
    private int $id;
    private int $orderId;
    private int $productId;
    private string $name;
    private int $stock;
    private int $quantity;
    private float $totalPrice;
    private string $description;
    private float $unitPrice;

    public function __construct(
        int $id,
        int $orderId,
        int $productId,
        int $stock,
        string $name,
        int $quantity,
        float $totalPrice,
        string $description,
        float $unitPrice
    )
    {
        $this->id = $id;
        $this->orderId = $orderId;
        $this->productId = $productId;
        $this->name = $name;
        $this->stock = $stock;
        $this->quantity = $quantity;
        $this->totalPrice = $totalPrice;
        $this->description = $description;
        $this->unitPrice = $unitPrice;
    }
    public function getStock(): int
    {
        return $this->stock;
    }
    public function getName(): string
    {
        return $this->name;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }
}
