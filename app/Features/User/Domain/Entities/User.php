<?php

namespace App\Features\User\Domain\Entities;

class User
{
    public function __construct(private ?int $id = null, private ?string $name = null, private ?string $email = null, private ?string $password = null) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
}
