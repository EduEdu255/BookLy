<x-head></x-head>

<div class="bg-[#14335B] text-white flex flex-col min-h-screen">

    <header class="flex justify-center items-center w-full max-w-6xl mx-auto">
        <a href="/" class="flex items-center space-x-2">
            <img src="{{ asset('img/logo.svg') }}" alt="Booknest Logo" class="w-48" />
        </a>
    </header>

    <form class="flex flex-col items-center w-full max-w-6xl mx-auto mt-20" action="{{ route('auth.register') }}"
        method="POST">
        @csrf
        <div>
            <label class="block mb-2" for="username">Nome:</label>
            <input class="min-w-[400px] border-2 border-[#919EAB33] py-3 pl-3 rounded-2xl" type="text"
                name="username" placeholder="Nome">
        </div>
        <div class="mt-5">
            <label class="block mb-2" for="email">Email:</label>
            <input class="min-w-[400px] border-2 border-[#919EAB33] py-3 pl-3 rounded-2xl" type="email" name="email"
                placeholder="seuemail@email.com">
        </div>
        <div class="mt-5 flex gap-2">
            <div>
                <label class="block mb-2" for="password">Senha:</label>
                <input class="border-2 border-[#919EAB33] py-3 pl-3 rounded-2xl" type="password" name="password"
                    placeholder="********">
            </div>
            <div>
                <label class="block mb-2" for="password_confirmation">Confirmar senha:</label>
                <input class="border-2 border-[#919EAB33] py-3 pl-3 rounded-2xl" type="password"
                    name="password_confirmation" placeholder="********">
            </div>
        </div>
        @if ($errors->any())
            <div class="text-red-300 pt-3 rounded w-full max-w-[400px]">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <button
            class="bg-[#E68C3A] mt-10 min-w-[400px] rounded-full py-3 cursor-pointer hover:bg-[#d97d11] transition-all duration-200">Criar
            Conta</button>
        <p class="mt-5">Já possui uma conta? <a href="/login" class="text-[#02A5FF] underline">Fazer Login</a></p>
    </form>

</div>

<x-footer></x-footer>
