<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BookTest extends TestCase
{
    public function test_index_returns_all_books_from_authenticated_user()
    {
        $user = User::factory()->create();

        $book1 = Book::factory()->create([
            'external_id' => 1,
            'title' => 'Book One',
            'user_id' => $user->id
        ]);
        $book2 = Book::factory()->create([
            'external_id' => 1,
            'title' => 'Book Two',
            'user_id' => $user->id
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/books');

        $response->assertStatus(200);

        $response->assertJsonFragment(['title' => 'Book One']);
        $response->assertJsonFragment(['title' => 'Book Two']);
    }

    public function test_guest_cannot_access_books_route()
    {
        $response = $this->getJson('/api/books');

        $response->assertStatus(401);
    }
}
