<?php

namespace App\Http\Controllers;

use App\Services\BooksService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;

class BookController extends Controller
{
    protected BooksService $service;

    public function __construct(BooksService $booksService)
    {
        $this->service = $booksService;
    }

    public function search(Request $request)
    {
        $books = $this->service->getSearchResult($request->input('book_name'));

        return view('app.books.search', [
            'books' => $books
        ]);
    }

    public function info(Request $request, string $external_id)
    {
        $book = $this->service->getBookInfo($external_id);
        $user_books = $request->user()->books;
        $user_has = $user_books->contains('external_id', $book['external_id']);

        return view('app.books.info', [
            'book' => $book,
            'user_has' => $user_has
        ]);
    }

    public function addToLib(Request $request)
    {
        $book = $request->input();
        $request->user()->books()->create($book);

        return redirect()->back()->with('success', 'Livro adicionado com sucesso!');
    }
}
