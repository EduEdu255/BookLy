<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $status = null;
        if ($request->filled('status')) {
            $status = $request->input('status');
        }

        $books = Book::getFiltered($user, $status);

        return view('app.home', [
            'books' => $books
        ]);
    }
}
