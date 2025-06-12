<x-head></x-head>

<div class="bg-[#F0EDED] text-[#1C252E] h-full min-h-screen">
    <div class="w-full max-w-2xl mx-auto pt-10">
        <a href="/my-library">
            < Voltar</a>
                <form class="mt-10" action="{{ route('notes.add') }}" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label class="mb-1.5 block" for="title">Título:</label>
                        <input class="w-full border-2 border-[#919EAB33] py-3 pl-3 rounded-2xl" type="text"
                            name="title" placeholder="Título do resumo">
                    </div>
                    <div class="mb-5">
                        <label class="mb-1.5 block" for="title">Conteúdo:</label>
                            <textarea class="w-full border-2 border-[#919EAB33] py-3 pl-3 rounded-2xl" name="description" id="description" cols="30" rows="10">Conteúdo do resumo</textarea>
                    </div>
                    <input type="hidden" name="book_id" value="{{ $book['id'] }}">
                    <input type="hidden" name="external_book_id" value="{{ $book['external_id'] }}">
                    <button
                        class="bg-[#E68C3A] font-semibold text-white w-full mt-10 rounded-2xl px-12 py-3 cursor-pointer hover:bg-[#d97d11] transition-all duration-200">Adicionar
                        resumo</button>
                </form>
    </div>
</div>

<x-footer></x-footer>
