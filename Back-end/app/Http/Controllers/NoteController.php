<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Request $request, Book $book)
    {
        return response()->json(['notes' => $book->notes]);
    }



    public function show(Request $request, int $id)
    {
        if (!$note = Note::find($id)) {
            return response()->json(['message' => 'Anotação não encontrada'], 404);
        }

        return response()->json(['note' => $note]);
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'book_id' => 'required|integer|exists:books,id'
        ]);

        $note = Note::create($validated);

        return response()->json([
            'message' => 'Anotação criada com sucesso',
            'note' => $note
        ], 201);
    }

    public function update(Request $request, int $id)
    {
        if (!$note = Note::find($id)) {
            return response()->json(['message' => 'Anotação não encontrada'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string|max:255'
        ]);

        $validated['book_id'] = $note->book_id;

        $note->update($validated);

        return response()->json(['message' => 'Anotação atualizada com sucesso']);
    }

    public function delete(Request $request, int $id)
    {
        if (!$note = Note::find($id)) {
            return response()->json(['message' => 'Anotação não encontrada'], 404);
        }

        $note->delete();

        return response()->json(['message' => 'Anotação deletada com sucesso']);
    }
}
