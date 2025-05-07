<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_retrieve_the_given_order(): void
    {
        $user = User::factory()->create();

        $order = Order::factory()->create([
            'user_id' => $user->getKey(),
        ]);

        Product::factory()->create([
            'name' => 'pencil',
        ]);

        $product = Product::factory()->create();

        $order->products()->attach($product->getKey(), $bd = [
            'quantity' => 1,
            'total_price' => $product->unit_price,
            'product_description' => $product->description,
            'product_unit_price' => $product->unit_price,
        ]);

        $productAttach = $order->products()->first();

        $this->getJson(route('order.show', $order->getKey()))
            ->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $order->getKey(),
                    'user_id' => $user->getKey(),
                    'products' => [
                        [
                            'id' => $productAttach->pivot->id,
                            'quantity' => $bd['quantity'],
                            'total_price' => $bd['total_price'],
                            'description' => $bd['product_description'],
                            'unit_price' => $bd['product_unit_price'],
                        ],
                    ],
                ],
            ]);

        $this->assertDatabaseHas(
            'order_products',
            [
                'id' => $productAttach->pivot->id,
                'quantity' => $bd['quantity'],
                'total_price' => $bd['total_price'],
                'product_description' => $bd['product_description'],
                'product_unit_price' => $bd['product_unit_price'],
            ],
        );
    }

    /**
     * @test
     */
    public function it_creates_an_order(): void
    {
        $user = User::factory()->create();

        $product1 = Product::factory()->create([
            'name' => 'pencil',
            'unit_price' => 1.50,
            'description' => 'A simple pencil',
        ]);

        $product2 = Product::factory()->create([
            'name' => 'notebook',
            'unit_price' => 3.00,
            'description' => 'A simple notebook',
        ]);

        $payload = [
            'user_id' => $user->getKey(),
            'products' => [
                [
                    'id' => $product1->getKey(),
                    'quantity' => 2,
                ],
                [
                    'id' => $product2->getKey(),
                    'quantity' => 1,
                ],
            ],
        ];

        $this->postJson(route('order.store'), $payload)
            ->assertCreated();

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->getKey(),
        ]);

        $this->assertDatabaseHas('order_products', [
            'product_id' => $product1->getKey(),
            'quantity' => $payload['products'][0]['quantity'],
            'product_unit_price' => $product1->unit_price,
            'product_description' => $product1->description,
            'total_price' => $payload['products'][0]['quantity'] * $product1->unit_price,
        ]);

        $this->assertDatabaseHas('order_products', [
            'product_id' => $product2->getKey(),
            'quantity' => $payload['products'][1]['quantity'],
            'product_unit_price' => $product2->unit_price,
            'product_description' => $product2->description,
            'total_price' => $payload['products'][1]['quantity'] * $product2->unit_price,
        ]);
    }

    /**
     * @test
     */
    public function it_deletes_products_from_an_order(): void
    {
        $user = User::factory()->create();

        $order = Order::factory()->create([
            'user_id' => $user->getKey(),
        ]);

        $product1 = Product::factory()->create([
            'name' => 'pencil',
            'unit_price' => 1.50,
            'description' => 'A simple pencil',
        ]);

        $product2 = Product::factory()->create([
            'name' => 'notebook',
            'unit_price' => 3.00,
            'description' => 'A simple notebook',
        ]);

        $order->products()->attach($product1->getKey(), [
            'quantity' => 2,
            'product_unit_price' => $product1->unit_price,
            'product_description' => $product1->description,
            'total_price' => 2 * $product1->unit_price,
        ]);

        $order->products()->attach($product2->getKey(), [
            'quantity' => 1,
            'product_unit_price' => $product2->unit_price,
            'product_description' => $product2->description,
            'total_price' => 1 * $product2->unit_price,
        ]);

        $payload = [
            'products' => [
                [
                    'id' => $product1->getKey(),
                ],
            ],
        ];

        $this->postJson(route('order.products.clear', $order->getKey()))
            ->dump()
            ->assertOk();

        $this->assertDatabaseMissing('order_products', [
            'order_id' => $order->getKey(),
            'product_id' => $product1->getKey(),
        ]);

        $this->assertDatabaseMissing('order_products', [
            'order_id' => $order->getKey(),
            'product_id' => $product2->getKey(),
        ]);
    }
}
