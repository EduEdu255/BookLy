<?php

namespace App\Http\Controllers;

use App\Services\BooksService;
use Illuminate\Http\Request;

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

        $user_has = false;

        if ($user_book = $user_books->firstWhere('external_id', $book['external_id'])) {
            $user_has = true;
            $book['status'] = $user_book->status;
        }

        return view('app.books.info', [
            'book' => $book,
            'user_has' => $user_has,
            'notes' => $user_book?->notes ?? collect()
        ]);
    }

    public function addToLib(Request $request)
    {
        $book = $request->input();
        $request->user()->books()->create($book);

        return redirect()->back()->with('success', 'Livro adicionado com sucesso!');
    }

    public function removeFromLib(Request $request)
    {
        $request->user()->books()
            ->where('external_id', $request->input('external_id'))
            ->delete();

        return redirect()->back()->with('success', 'Livro removido da biblioteca!');
    }

    public function setStatus(Request $request)
    {
        $user = $request->user();
        $user_book = $user->books()->where('external_id', $request->input('external_id'))->first();

        if ($user_book) {
            $user_book->status = $request->input('status');
            $user_book->save();
        }

        return redirect()->back()->with('success', 'Status atualizado com sucesso!');
    }
}
