<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BooksService
{
    protected string $url = 'https://www.googleapis.com/books/v1/';

    public function getSearchResult($book_name)
    {
        $response = Http::get($this->url . 'volumes?q=intitle:' . $book_name . '&maxResults=18');
        $json = $response->json();

        foreach ($json['items'] ?? [] as $item) {
            $volume_info = $item['volumeInfo'];

            $books[] = [
                'external_id' => $item['id'] ?? null,
                'title' => $volume_info['title'] ?? 'Título desconhecido',
                'author' => $volume_info['authors'][0] ?? 'Autor desconhecido',
                'description' => $volume_info['description'] ?? 'Sem descrição disponível',
                'cover' => $volume_info['imageLinks']['thumbnail'] ?? null
            ];
        }

        return $books;
    }

    public function getBookInfo($external_id)
    {
        $response = Http::get($this->url . 'volumes/' . $external_id);
        $json = $response->json();

        $volume_info = $json['volumeInfo'] ?? [];

        $book = [
            'external_id' => $json['id'] ?? null,
            'title' => $volume_info['title'] ?? 'Título desconhecido',
            'author' => $volume_info['authors'][0] ?? 'Autor desconhecido',
            'description' => $volume_info['description'] ?? 'Sem descrição disponível',
            'cover' => $volume_info['imageLinks']['thumbnail'] ?? null
        ];

        return $book;
    }
}
