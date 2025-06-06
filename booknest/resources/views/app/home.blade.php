<x-head></x-head>

<div class="bg-[#14335B] text-white flex flex-col min-h-screen">
    <h1>Teste</h1>
    <form action="{{ route('auth.logout') }}" method="POST">
        @csrf
        <button>Exit</button>
    </form>
</div>

<x-footer></x-footer>
