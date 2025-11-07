<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ClientsTest extends TestCase
{
    use RefreshDatabase;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_logged_user_can_access_clients(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->getJson('/api/v1/clients');

        $response->assertStatus(200);
    }

    public function test_unlogged_user_cannot_access_clients(): void
    {
        $response = $this->getJson('/api/v1/clients');
        
        $response->assertStatus(401);
    }

    public function test_client_create_endpoint_has_validation(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->postJson('/api/v1/clients', [
            "name" => "",
            "email" => fake()->email
        ]);
        
        $response->assertStatus(422);
        $response->assertInvalid(['name']);
    }

    public function test_logged_user_with_correct_data_can_create_a_client(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->postJson('/api/v1/clients', [
            "name" => fake()->name,
            "email" => fake()->email,
            "phone" => fake()->phoneNumber
        ]);
        
        $response->assertStatus(201);
    }

    public function test_logged_user_with_correct_data_can_update_a_client(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $clientData = [
            "name" => fake()->name,
            "email" => fake()->email,
            "phone" => fake()->phoneNumber
        ];

        $client = Client::factory()->create();

        $response = $this->putJson('/api/v1/clients/'.$client->id, $clientData);
        
        $response->assertStatus(200);
        $this->assertDatabaseHas("clients", $clientData);
    }

    public function test_logged_user_can_delete_a_client(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $client = Client::factory()->create();

        $response = $this->deleteJson('/api/v1/clients/'.$client->id);
        
        $response->assertStatus(204);
        # $this->assertDatabaseMissing("clients", $client->toArray());
    }
}
