<?php

namespace App\Http\Controllers;

use App\Services\BooksService;
use Illuminate\Http\Request;

class ApiBookController extends Controller
{
    protected BooksService $service;

    public function __construct(BooksService $booksService)
    {
        $this->service = $booksService;
    }

    public function index(Request $request)
    {
        $books = $request->user()->books;
        return response()->json($books);
    }

    public function search(Request $request)
    {
        $bookName = $request->input('book_name');
        $books = $this->service->getSearchResult($bookName);

        return response()->json($books);
    }

    public function info(Request $request, string $external_id)
    {
        $book = $this->service->getBookInfo($external_id);
        $user_books = $request->user()->books;

        $user_book = $user_books->firstWhere('external_id', $book['external_id']);
        $user_has = false;

        if ($user_book) {
            $user_has = true;
            $book['status'] = $user_book->status;
        }

        return response()->json([
            'book' => $book,
            'user_has' => $user_has
        ]);
    }

    public function addToLib(Request $request)
    {
        $validated = $request->validate([
            'external_id' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'author' => 'nullable|string',
            'cover' => 'nullable|string',
        ]);

        $book = $request->user()->books()->create($validated);

        return response()->json([
            'message' => 'Livro adicionado com sucesso!',
            'book' => $book
        ], 201);
    }

    public function removeFromLib(Request $request, string $external_id)
    {
        $deleted = $request->user()->books()
            ->where('external_id', $external_id)
            ->delete();

        return response()->json([
            'message' => $deleted ? 'Livro removido com sucesso!' : 'Livro não encontrado.'
        ]);
    }
}
