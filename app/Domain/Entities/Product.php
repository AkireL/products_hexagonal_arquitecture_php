<?php

namespace App\Domain\Entities;

class Product
{
    public function __construct(private int $id, private string $name, private float $unitPrice, private int $stock=0, private ?string $description=null) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    public function getStock(): int
    {
        return $this->stock;
    }
}
