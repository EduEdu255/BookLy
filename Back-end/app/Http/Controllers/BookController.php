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
        $new_book = $request->validate([
            'external_id' => 'required|int',
            'title' => 'required|string',
            'description' => 'required|string',
            'author' => 'required|string',
            'status' => 'string',
            'published_at' => 'required|date',
        ]);

        Book::create($new_book);

        return response()->json([
            'message' => 'Book added succesfully',
            'book' => $new_book
        ], 201);
    }
}
