<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        return response()->json($request->user()->books);
    }



    public function show(Request $request, int $id)
    {
        if (!$book = $request->user()->books()->find($id)) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json($book);
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'external_id' => 'required|int',
            'title' => 'required|string',
            'description' => 'required|string',
            'author' => 'required|string',
            'status' => 'string',
            'published_at' => 'required|date',
        ]);

        $validated['user_id'] = $request->user()->id;

        $new_book = Book::create($validated);

        return response()->json([
            'message' => 'Book added succesfully',
            'book' => $new_book
        ], 201);
    }

    public function delete(int $id)
    {
        if (!$book = Book::find($id)) {
            return response()->json(['message' => 'Livro não encontrado'], 404);
        }

        $book->delete();

        return response()->json(['message' => 'Livro deletado com sucesso']);
    }
}
