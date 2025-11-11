<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class OrdersTest extends TestCase
{
     use RefreshDatabase;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_logged_user_can_access_orders(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->getJson('/api/v1/orders');

        $response->assertStatus(200);
    }

    public function test_unlogged_user_cannot_access_orders(): void
    {
        $response = $this->getJson('/api/v1/orders');
        
        $response->assertStatus(401);
    }

    public function test_orders_create_endpoint_has_validation(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->postJson('/api/v1/orders', [
            "client_id" => "",
            "products" => ""
        ]);
        
        $response->assertStatus(422);
        $response->assertInvalid(['client_id', 'products']);
    }

    public function test_create_order_endpoint_validate_product_existence(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $product = Product::factory()->create();
        $client = Client::factory()->create();

        $response = $this->postJson('/api/v1/orders', [
            "client_id" => $client?->id,
            "products" => [$product?->id, 2]
        ]);
        
        $response->assertStatus(422);
    }

    public function test_logged_user_with_correct_data_can_create_an_order(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $product = Product::factory()->create();
        $client = Client::factory()->create();

        $response = $this->postJson('/api/v1/orders', [
            "client_id" => $client?->id,
            "products" => [$product?->id]
        ]);
        
        $response->assertStatus(201);
    }

    public function test_logged_user_can_access_order_endpoint(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $order = Order::factory()->create();

        $response = $this->getJson('/api/v1/orders/' . $order->id);
        
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                "id" => $order->id,
                "client" => [
                    "id" => $order->client_id
                ] 
            ] 
        ]);
    }

    public function test_logged_user_with_correct_data_can_update_an_order(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $product = Product::factory()->create();
        $client = Client::factory()->create();
        $order = Order::factory()->create();

        $orderFormData = [
            "client_id" => $client?->id,
            "products" => [$product?->id]
        ];

        $response = $this->putJson('/api/v1/orders/' . $order->id, $orderFormData);
        
        $response->assertStatus(200);
        unset($orderFormData['products']);
        $this->assertDatabaseHas("orders", $orderFormData);
    }

    public function test_logged_user_can_delete_an_order(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $order = Order::factory()->create();

        $response = $this->deleteJson('/api/v1/orders/'.$order->id);
        
        $response->assertStatus(204);
    }
}
