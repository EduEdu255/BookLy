<x-head></x-head>

<div class="bg-[#F0EDED] text-white flex flex-col min-h-screen">
    <img class="w-screen h-28 object-cover" src="{{ asset('img/books-image.jpg') }}" alt="Books">

    <header class="bg-[#213E60] py-3">
        <div class="flex justify-between items-center w-full max-w-6xl mx-auto">
            <div class="flex items-center gap-3">
                <img class="w-full max-w-12 rounded-full" src="{{ asset('img/profile.jpg') }}" alt="">
                <h3 class="text-xl font-semibold">{{ Auth::user()->username }}</h3>
                <a class="underline text-sm mb-3" href="profile/edit">Editar</a>
            </div>
            <form action="{{ route('auth.logout') }}" method="POST">
                @csrf
                <button class="cursor-pointer">Logout</button>
            </form>
        </div>
    </header>

    <section class="w-full max-w-6xl mx-auto text-[#1C252E] bg-white mt-10 p-5 rounded-2xl">
        <h3 class="text-2xl font-medium mb-3">Sobre</h3>
        <p>{{ Auth::user()->bio }}</p>
    </section>

    <section class="w-full max-w-6xl mx-auto text-[#1C252E] mt-10">
        <div class="flex justify-between items-center">
            <h3 class="text-3xl font-medium mb-3">Minha biblioteca</h3>
            <a href="/books/search" class="bg-[#E68C3A] hover:scale-95 transition-all duration-200 text-white font-semibold px-12 py-2 rounded-xl">Adicionar Livro</a>
        </div>

        <div class="mt-5">
            <span>Livros do usuário autenticado</span>
        </div>
    </section>

</div>

<x-footer></x-footer>
