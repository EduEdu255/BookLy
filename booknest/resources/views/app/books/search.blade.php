<x-head></x-head>

<div class="bg-[#F0EDED] text-[#1C252E] h-full min-h-screen">
    <div class="w-full max-w-2xl mx-auto pt-10">
        <a href="/my-library">
            < Voltar</a>
                <form class="flex items-baseline gap-5" action="{{ route('books.search.result') }}">
                    <input class="w-full border-2 border-[#919EAB33] py-3 pl-3 rounded-2xl" type="text" name="book_name"
                        placeholder="Nome do livro...">
                    <button
                        class="bg-[#E68C3A] font-semibold text-white mt-10 rounded-2xl px-12 py-3 cursor-pointer hover:bg-[#d97d11] transition-all duration-200">Pesquisar</button>
                </form>
    </div>

    <div class="w-full max-w-2xl mx-auto pt-10">
        @if ($books && count($books))
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($books as $book)
                    <a href="/books/{{ $book['external_id'] }}"
                        class="border h-full max-h-[370px] border-[#919EAB33] rounded-2xl shadow-sm hover:scale-95 transition-all duration-200">
                        <img src="{{ $book['cover'] }}" alt="Capa do livro"
                            class="w-full h-72 object-cover rounded-t-2xl">
                        <div class="p-3 bg-white rounded-b-2xl">
                            <h3 class="text-xl font-semibold">
                                {{ \Illuminate\Support\Str::limit($book['title'], 15) }}
                            </h3>
                            <p class="mt-2 text-gray-600">
                                {{ \Illuminate\Support\Str::limit($book['author'], 18) }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
        <span class="block h-10"></span>
    </div>
</div>

<x-footer></x-footer>
