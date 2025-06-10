<x-head></x-head>

<div class="bg-[#F0EDED] text-[#1C252E] h-full min-h-screen pb-10">
    <img class="w-screen h-28 object-cover" src="{{ asset('img/books-image.jpg') }}" alt="Books">

    <x-header></x-header>

    <div class="w-full max-w-6xl mx-auto mt-5">
        <a href="/my-library">
            < Voltar</a>
    </div>

    <section class="w-full max-w-6xl mx-auto text-[#1C252E] mt-5 flex gap-10">
        <div class="w-full flex-1">
            <img src="{{ $book['cover'] }}" alt="Capa do livro" class="w-max min-w-[180px] h-72 object-cover rounded-2xl">
            <h3 class="text-2xl font-semibold mt-1.5">{{ $book['title'] }}</h3>
            <p class="mt-1">{{ $book['author'] }}</p>
        </div>
        <div class="flex-4">
            <p>{{ strip_tags($book['description']) }}</p>
            @if ($user_has)
                <div class="flex items-center gap-3 mt-5">
                    <img src="{{ asset('img/grid-icon.svg') }}" alt="Grid icon">
                    <p class="text-[#006C9C] font-medium">Essa edição já está na sua biblioteca, clique na opção
                        abaixo para visualizar a biblioteca</p>
                </div>
                <div class="flex items-baseline gap-5">
                    <a href="/my-library"
                        class="bg-[#006C9C] inline-block font-semibold text-white mt-3 rounded-2xl px-12 py-3 cursor-pointer hover:scale-95 transition-all duration-200">Ir
                        para a biblioteca</a>
                    <form class="mt-5" action="{{ route('books.remove') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="external_id" value="{{ $book['external_id'] }}">
                        <button
                            class="bg-red-400 font-semibold text-white mt-3 rounded-2xl px-12 py-3 cursor-pointer hover:scale-95 transition-all duration-200">Remover
                            da biblioteca</button>
                    </form>
                </div>
                <h3 class="mt-10 text-2xl font-bold">Status de leitura</h3>
                <div class="mt-3 mb-10 flex items-center gap-3">
                    <div class="rounded-xl w-max h-full">
                        <form action="{{ route('books.status') }}" method="POST" class="w-full h-full">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="external_id" value="{{ $book['external_id'] }}">
                            <input type="hidden" name="status" value="ja li">
                            <button
                                class="{{ $book['status'] == 'ja li' ? 'bg-[#006C9C] text-white' : 'bg-gray-300 text-gray-700' }} font-semibold px-5 w-full h-full py-2 rounded-xl cursor-pointer hover:scale-95 transition-all duration-200">Já
                                li</button>
                        </form>
                    </div>
                    <div class="rounded-xl w-max h-full">
                        <form action="{{ route('books.status') }}" method="POST" class="w-full h-full">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="external_id" value="{{ $book['external_id'] }}">
                            <input type="hidden" name="status" value="estou lendo">
                            <button
                                class="{{ $book['status'] == 'estou lendo' ? 'bg-[#006C9C] text-white' : 'bg-gray-300 text-gray-700' }} font-semibold px-5 w-full h-full py-2 rounded-xl cursor-pointer hover:scale-95 transition-all duration-200">Estou
                                lendo</button>
                        </form>
                    </div>
                    <div class="rounded-xl w-max h-full">
                        <form action="{{ route('books.status') }}" method="POST" class="w-full h-full">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="external_id" value="{{ $book['external_id'] }}">
                            <input type="hidden" name="status" value="quero ler">
                            <button
                                class="{{ $book['status'] == 'quero ler' ? 'bg-[#006C9C] text-white' : 'bg-gray-300 text-gray-700' }} font-semibold px-5 w-full h-full py-2 rounded-xl cursor-pointer hover:scale-95 transition-all duration-200">Quero
                                ler</button>
                        </form>
                    </div>
                </div>
                <div class="flex justify-between items-baseline">
                    <h3 class="mt-10 text-2xl font-bold">Meus resumos</h3>
                    <a class="bg-[#E68C3A] font-semibold text-white mt-3 rounded-xl px-8 py-2 cursor-pointer hover:scale-95 transition-all duration-200"
                        href="/notes/{{ $book['external_id'] }}">Adicionar Resumo</a>
                </div>
                @forelse ($notes as $note)
                    <div class="flex justify-between items-start my-5 bg-white shadow-sm p-5 rounded-2xl">
                        <div>
                            <h3 class="text-lg font-medium">{{ $note['title'] }}</h3>
                            <p class="mt-1.5">{{ $note['description'] }}</p>
                        </div>
                        <form action="{{ route('notes.delete') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="note_id" value="{{ $note['id'] }}">
                            <button class="underline text-red-400 text-sm cursor-pointer">Remover</button>
                        </form>
                    </div>
                @empty
                    <p class="mt-5">Nenhum resumo sobre esse livro...</p>
                @endforelse
            @else
                <div class="flex items-center gap-3 mt-5">
                    <img src="{{ asset('img/grid-icon.svg') }}" alt="Grid icon">
                    <p class="text-[#006C9C] font-medium">Essa edição ainda não está na sua biblioteca, clique
                        na opção
                        abaixo para adicionar</p>
                </div>
                <form class="mt-5" action="{{ route('books.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="external_id" value="{{ $book['external_id'] }}">
                    <input type="hidden" name="title" value="{{ $book['title'] }}">
                    <input type="hidden" name="description" value="{{ $book['description'] }}">
                    <input type="hidden" name="author" value="{{ $book['author'] }}">
                    <input type="hidden" name="cover" value="{{ $book['cover'] }}">
                    <button
                        class="bg-[#E68C3A] font-semibold text-white mt-3 rounded-2xl px-12 py-3 cursor-pointer hover:scale-95 transition-all duration-200">Adicionar
                        à biblioteca</button>
                </form>
            @endif
        </div>
    </section>
</div>

<x-footer></x-footer>
