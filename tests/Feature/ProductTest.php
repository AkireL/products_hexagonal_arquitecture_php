<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function it_create_a_product(): void
    {
        $data = [
            'name' => "book",
            'description' => "pink 5mm.",
            'stock' => 10,
            'unit_price' => "12.80",
        ];

        $this->postJson(route('product.store'), $data)
            ->assertCreated()
            ->dump()
            ->assertJson(["message" => "Product created successfully"]);
    }

    /**
     * @test
     */
    public function it_return_the_product_list()
    {
        Product::factory()->count(10)->create();

        $this->getJson(route('product.index'))
            ->assertOk()
            ->assertJsonCount(10, 'data');
    }
}
