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
        if(!$note = Note::find($id)){
            return response()->json(['message' => 'Anotação não encontrada'], 404);
        }

        return response()->json(['note' => $note]);
    }

    public function store(Request $request)
    {
        //
    }

    public function delete(Request $request, int $id)
    {
        if(!$note = Note::find($id)){
            return response()->json(['message' => 'Anotação não encontrada'], 404);
        }

        $note->delete();

        return response()->json(['message' => 'Anotação deletada com sucesso']);
    }
}
