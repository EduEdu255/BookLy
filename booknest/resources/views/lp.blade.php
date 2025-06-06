<x-head></x-head>

<div class="bg-[#14335B] text-white flex flex-col min-h-screen">


    <header class="flex justify-between items-center w-full max-w-6xl mx-auto">
        <a href="/" class="flex items-center space-x-2">
            <img src="{{ asset('img/logo.svg') }}" alt="Booknest Logo" class="w-48" />
        </a>
        <div class="space-x-4">
            <a href="/login"
                class="bg-[#F7941E] hover:bg-[#d97d11] transition-all duration-200 text-white font-semibold px-8 py-2.5 rounded-xl">Entrar</a>
            <a href="/register"
                class="bg-[#F7941E] hover:bg-[#d97d11] transition-all duration-200 text-white font-semibold px-8 py-2.5 rounded-xl">Cadastrar</a>
        </div>
    </header>

    <main class="flex-1 flex items-center justify-between w-full max-w-6xl mx-auto">
        <div class="max-w-lg">
            <h1 class="text-5xl font-serif font-semibold leading-snug">
                A Sociedade Secreta <br />
                das Folhas Amarelas
            </h1>
        </div>
        <div>
            <img src="{{ asset('img/estante.svg') }}" alt="Estante com livros" class="max-w-md w-full" />
        </div>
    </main>

    <footer class="bg-[#102846] py-12 w-full mx-auto">
        <p class="mt-4 md:mt-0 text-center">© 2025 booknest. Todos os direitos reservados.</p>
    </footer>

</div>

<x-footer></x-footer>
