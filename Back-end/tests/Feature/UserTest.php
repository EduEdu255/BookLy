<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;



    public function test_authenticated_user_can_access_me_route()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/me');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }



    public function test_guest_cannot_access_me_route()
    {
        $response = $this->getJson('/me');

        $response->assertStatus(404);
    }



    public function test_find_by_id_method_returns_user_when_found()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'message' => 'User found successfully',
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }



    public function test_find_by_id_method_returns_message_when_not_found()
    {
        $response = $this->getJson("/api/users/1");

        $response->assertStatus(404);

        $response->assertJsonFragment([
            'message' => 'User not found',
        ]);
    }
}
