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
            'name' => 'book',
            'description' => 'pink 5mm.',
            'stock' => 10,
            'unit_price' => '12.80',
        ];

        $this->postJson(route('product.store'), $data)
            ->assertCreated()
            ->assertJson(['message' => 'Product created successfully']);
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

    /**
     * @test
     */
    public function it_retrieves_a_product(): void
    {
        $product = Product::factory()->create();

        $this->getJson(route('product.show', $product->id))
            ->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'stock' => $product->stock,
                    'unit_price' => $product->unit_price,
                ],
            ]);
    }

    /**
     * @test
     */
    public function it_updates_a_product(): void
    {
        $product = Product::factory()->create();

        $updatedData = [
            'id' => $product->getKey(),
            'name' => 'updated book',
            'unit_price' => '15.50',
            'stock' => 20,
            'description' => 'updated description',
        ];

        $this->putJson(route('product.update', $product->id), $updatedData)
            ->assertOk()
            ->assertJson([
                'message' => 'Product updated successfully',
            ]);

        $this->assertDatabaseHas('products', $updatedData);
    }

    /**
     * @test
     */
    public function it_deletes_a_product(): void
    {
        $product = Product::factory()->create();

        $this->deleteJson(route('product.destroy', $product->id))
            ->assertNoContent();

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
