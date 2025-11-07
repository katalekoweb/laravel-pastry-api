<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_register_endpoint_with_invalid_data_returns_error(): void
    {
        $formData = [
            "name" => fake()->name,
            "email" => "email",
            "password" => "12345",
            "password_confirmation" => "123456"
        ];

        $response = $this->postJson('/api/v1/register', $formData);

        $response->assertStatus(422);
        $response->assertInvalid(['email', 'password']);
    }

    public function test_register_endpoint_with_valid_data_create_user_successful(): void
    {
        $formData = [
            "name" => fake()->name,
            "email" => fake()->email,
            "password" => "12345",
            "password_confirmation" => "12345"
        ];

        $response = $this->postJson('/api/v1/register', $formData);

        $response->assertStatus(201);
    }

    public function test_user_with_invalid_credentials_in_login_returns_error(): void
    {
        $formData = [
            "email" => fake()->email,
            "password" => "12345",
        ];

        User::factory()->create($formData);
        $formData['password'] = "123456";

        $response = $this->postJson('/api/v1/login', $formData);

        $response->assertStatus(404);
    }

    public function test_user_with_correct_credentials_login_successful(): void
    {
        $formData = [
            "email" => fake()->email,
            "password" => "12345",
        ];

        $user = User::factory()->create($formData);

        $response = $this->postJson('/api/v1/login', $formData);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 200,
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
            ],
        ]);
    }

    public function test_unlogged_user_cannot_access_logout_endpoint () {
        $user = User::factory()->create();

        $response = $this->post("/api/v1/logout");

        $response->assertStatus(500);
    }

    public function test_logged_user_can_logout_using_token () {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->post("/api/v1/logout");

        $response->assertStatus(200);
        $response->assertJson([
            "message" => "Sessão terminada com sucesso"
        ]);
    }
}
