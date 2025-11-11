<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_logged_user_can_access_products(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->getJson('/api/v1/products');

        $response->assertStatus(200);
    }

    public function test_unlogged_user_cannot_access_products(): void
    {
        $response = $this->getJson('/api/v1/products');
        
        $response->assertStatus(401);
    }

    public function test_product_create_endpoint_has_validation(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->postJson('/api/v1/products', [
            "name" => "",
            "price" => rand(100, 999)
        ]);
        
        $response->assertStatus(422);
        $response->assertInvalid(['name', 'photo']);
    }

    public function test_logged_user_with_correct_data_can_create_a_product(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $photo = UploadedFile::fake()->create('photo.png', 100);
        $category = Category::factory()->create();

        $response = $this->postJson('/api/v1/products', [
            "name" => fake()->name,
            "category_id" => $category->id,
            "price" => rand(100, 999),
            "photo" => $photo
        ]);
        
        $response->assertStatus(201);
    }

    public function test_logged_user_can_access_product_endpoint(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $product = Product::factory()->create();

        $response = $this->getJson('/api/v1/products/' . $product->id);
        
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                "name" => $product->name,
                "category_id" => $product->category_id,
                "price" => $product->price
            ] 
        ]);
    }

    public function test_logged_user_with_correct_data_can_update_a_product(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $product = Product::factory()->create();

        $productData = [
            "name" => fake()->name,
            "category_id" => $product->category_id,
            "price" => rand(100, 999)
        ];

        $response = $this->putJson('/api/v1/products/'.$product->id, $productData);
        
        $response->assertStatus(200);
        $this->assertDatabaseHas("products", $productData);
    }

    public function test_logged_user_can_delete_a_product(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $product = Product::factory()->create();

        $response = $this->deleteJson('/api/v1/products/'.$product->id);
        
        $response->assertStatus(204);
    }
}
