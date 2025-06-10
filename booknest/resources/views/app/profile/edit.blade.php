<x-head></x-head>

<div class="bg-[#F0EDED] text-white flex flex-col min-h-screen">
    <img class="w-screen h-28 object-cover" src="{{ asset('img/books-image.jpg') }}" alt="Books">

    <x-header></x-header>

    <div class="w-full max-w-6xl mx-auto mt-5 text-[#1C252E]">
        <a href="/my-library">
            < Voltar</a>
    </div>

    <section class="w-full max-w-6xl mx-auto text-[#1C252E] bg-white mt-5 p-5 rounded-2xl">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-10">
            @csrf
            @method('PUT')
            <div class="flex flex-col items-center justify-center border-2 border-[#919EAB33] rounded-xl p-4">
                <label for="photo" class="cursor-pointer">
                    <img src="{{ asset('img/profile.jpg') }}" alt="Foto de perfil"
                        class="rounded-full w-32 h-32 object-cover mb-2">
                    <p class="text-sm text-gray-500 text-center">Upload photo</p>
                </label>
                <input type="file" id="photo" name="photo" class="hidden">
                <p class="text-xs text-gray-400 mt-2">Tipos permitidos: .jpeg, .jpg, .png</p>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <div class="mb-3">
                    <label class="block mb-1.5" for="username">Nome:</label>
                    <input type="text" name="username" placeholder="Nome"
                        class="input border-2 border-[#919EAB33] py-3 pl-3 rounded-2xl w-full"
                        value="{{ Auth::user()->username }}">
                </div>
                <div class="mb-3">
                    <label class="block mb-1.5" for="bio">Sobre:</label>
                    <textarea name="bio" placeholder="Sobre"
                        class="input resize-none h-32 border-2 border-[#919EAB33] py-3 pl-3 rounded-2xl w-full">{{ Auth::user()->bio }}</textarea>
                </div>
                <button type="submit"
                    class="bg-[#006C9C] hover:scale-95 transition-all duration-200 cursor-pointer text-white font-semibold px-4 py-2 rounded-xl">
                    Salvar alterações
                </button>
            </div>
        </form>
    </section>
</div>

<x-footer></x-footer>
