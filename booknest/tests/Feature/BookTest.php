<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    private function getToken(): string
    {
        $user = User::factory()->create();
        return $user->createToken('api_token')->plainTextToken;
    }

    private function addFakeBookToLibrary(string $token)
    {
        return $this->postJson('/api/books', [
            'external_id' => 'rmv001',
            'title' => 'O Hobbit',
            'description' => 'Um livro de aventura.',
            'author' => 'J.R.R. Tolkien',
            'cover' => 'https://example.com/hobbit.jpg'
        ], [
            'Authorization' => "Bearer $token"
        ]);
    }

    public function test_add_book_to_library()
    {
        $response = $this->addFakeBookToLibrary($this->getToken());

        $response->assertStatus(201)
            ->assertJsonFragment(['message' => 'Livro adicionado com sucesso!']);
    }

    public function test_list_books_in_user_library()
    {
        $this->addFakeBookToLibrary($token = $this->getToken());

        $response = $this->getJson('/api/books', [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'O Hobbit']);
    }

    public function test_remove_book_from_library()
    {
        $this->addFakeBookToLibrary($token = $this->getToken());

        $this->postJson('/api/books', [
            'external_id' => 'rmv001',
        ], [
            'Authorization' => "Bearer $token"
        ]);

        $response = $this->deleteJson('/api/books/rmv001', [], [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Livro removido com sucesso!']);
    }
}
