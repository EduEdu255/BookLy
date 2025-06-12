<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_returns_token()
    {
        $response = $this->postJson('/api/register', [
            'username' => 'jhon_doe',
            'email' => 'jhon@email.com',
            'password' => 'secret123'
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['token']);
    }

    public function test_login_returns_token()
    {
        User::factory()->create([
            'username' => 'jhon_doe',
            'email' => 'john@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'john@example.com',
            'password' => 'secret123'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    public function test_invalid_login_returns_error()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'fake@example.com',
            'password' => 'invalid'
        ]);

        $response->assertStatus(401)
            ->assertJsonStructure(['email']);
    }
}
