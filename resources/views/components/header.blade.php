<header class="text-white bg-[#213E60] py-3">
    <div class="flex justify-between items-center w-full max-w-6xl mx-auto">
        <div class="flex items-center gap-3">
            <img class="w-full max-w-12 rounded-full" src="{{ asset('img/profile.jpg') }}" alt="">
            <h3 class="text-xl font-semibold">{{ Auth::user()->username }}</h3>
            <a class="underline text-sm mb-3" href="profile/edit">Editar</a>
        </div>
        <div class="flex gap-12">
            <a href="{{ route('home') }}">Minha biblioteca</a>
            <a href="/books/search">Pesquisar</a>
            <form action="{{ route('auth.logout') }}" method="POST">
                @csrf
                <button class="cursor-pointer">Logout</button>
            </form>
        </div>
    </div>
</header>
