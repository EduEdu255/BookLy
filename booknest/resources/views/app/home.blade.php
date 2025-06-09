<x-head></x-head>

<div class="bg-[#F0EDED] text-white flex flex-col min-h-screen">
    <img class="w-screen h-28 object-cover" src="{{ asset('img/books-image.jpg') }}" alt="Books">

    <x-header></x-header>

    <section class="w-full max-w-6xl mx-auto text-[#1C252E] bg-white mt-5 p-5 rounded-2xl">
        <h3 class="text-2xl font-medium mb-3">Sobre</h3>
        <p>{{ Auth::user()->bio }}</p>
    </section>

    <section class="w-full max-w-6xl mx-auto text-[#1C252E] mt-10">
        <div class="flex justify-between items-center">
            <h3 class="text-3xl font-medium mb-3">Minha biblioteca</h3>
            <a href="/books/search"
                class="bg-[#E68C3A] hover:scale-95 transition-all duration-200 text-white font-semibold px-12 py-2 rounded-xl">Adicionar
                Livro</a>
        </div>

         <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-6 gap-6 mt-5 mb-10">
            @foreach ($books as $book)
                <a href="/books/{{ $book['external_id'] }}"
                    class="border h-full max-h-[370px] border-[#919EAB33] rounded-2xl shadow-sm hover:scale-95 transition-all duration-200">
                    <img src="{{ $book['cover'] }}" alt="Capa do livro" class="w-full h-72 object-cover rounded-t-2xl">
                    <div class="p-3 bg-white rounded-b-2xl">
                        <h3 class="text-xl font-semibold">
                            {{ \Illuminate\Support\Str::limit($book['title'], 12) }}
                        </h3>
                        <p class="mt-2 text-gray-600">
                            {{ \Illuminate\Support\Str::limit($book['author'], 18) }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

</div>

<x-footer></x-footer>
