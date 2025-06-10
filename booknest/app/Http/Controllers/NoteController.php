<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function new(Request $request, string $external_id)
    {
        $user_books = $request->user()->books;

        return view('app.notes.new', [
            'book' => $user_books->firstWhere('external_id', $external_id)
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'book_id' => 'required|integer',
            'external_book_id' => 'required|string'
        ]);

        Note::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'book_id' => $validated['book_id'],
            'external_book_id' => $validated['external_book_id'],
        ]);

        return redirect('books/' . $validated['external_book_id']);
    }
}
