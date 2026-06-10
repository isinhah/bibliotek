<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans text-gray-900 antialiased min-h-screen flex flex-col">

<nav class="bg-slate-900 text-slate-100 shadow-md border-b border-slate-800">
    <div class="container mx-auto px-4 py-3 flex flex-col sm:flex-row justify-between items-center gap-4">

        <div class="flex flex-col sm:flex-row items-center gap-6 w-full sm:w-auto text-center sm:text-left">
            <a href="/" class="text-xl font-bold tracking-wider hover:text-emerald-400 transition">
                Bibliotek
            </a>
            <div class="flex flex-wrap justify-center gap-4 text-sm font-medium">
                <a href="{{ route('categories.public') }}" class="text-slate-300 hover:text-white transition">Categorias</a>
                <a href="{{ route('authors.index') }}" class="text-slate-300 hover:text-white transition">Autores</a>

                @auth
                    @unlessrole('admin')
                    <a href="{{ route('loans.index') }}" class="text-slate-300 hover:text-white transition">Meus Empréstimos</a>
                    @endunlessrole
                @endauth

                @role('admin')
                <span class="text-slate-700 hidden sm:inline">|</span>
                <a href="{{ route('categories.index') }}" class="text-emerald-400 hover:text-emerald-300 transition font-semibold">
                    Categorias
                </a>
                <a href="{{ route('admin.authors.index') }}" class="text-emerald-400 hover:text-emerald-300 transition font-semibold">
                    Autores
                </a>
                <a href="{{ route('admin.books.index') }}" class="text-emerald-400 hover:text-emerald-300 transition font-semibold">
                    Livros
                </a>
                <a href="{{ route('admin.loans.index') }}" class="text-emerald-400 hover:text-emerald-300 transition font-semibold">
                    Empréstimos
                </a>
                @endrole
            </div>
        </div>

        <div class="flex items-center gap-4 text-sm font-medium w-full sm:w-auto justify-center sm:justify-end">
            @auth
                <span class="text-slate-400">
                    Olá, <span class="capitalize text-slate-200 font-semibold">{{ auth()->user()->name }}</span>
                </span>

                <form action="{{ route('logout') }}" method="POST" class="m-0 inline">
                    @csrf
                    <button type="submit" class="bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 px-3 py-1.5 rounded-lg text-xs font-semibold shadow-sm transition">
                        Sair
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-slate-300 hover:text-white transition">
                    Entrar
                </a>
                <a href="{{ route('register') }}" class="bg-emerald-600 text-white hover:bg-emerald-500 px-3 py-1.5 rounded-lg font-semibold shadow-sm transition text-xs">
                    Criar Conta
                </a>
            @endauth
        </div>

    </div>
</nav>

<main class="container mx-auto my-8 px-4 flex-1">
    {{ $slot }}
</main>

</body>
</html>
