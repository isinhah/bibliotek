<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans text-gray-900 antialiased min-h-screen flex flex-col">

<nav class="bg-slate-950 text-slate-100 border-b border-slate-900 shadow-lg">
    <div class="container mx-auto px-6 py-4 flex flex-col sm:flex-row justify-between items-center gap-4">

        <div class="flex items-center gap-8 w-full sm:w-auto">
            <a href="/" class="text-xl font-bold tracking-tight text-white transition duration-200">
                Bibliotek<span class="text-[#b91c1c]">.</span>
            </a>
            <div class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-400">
                <a href="{{ route('categories.public') }}" class="hover:text-[#b91c1c] transition-colors duration-200">Categorias</a>
                <a href="{{ route('authors.index') }}" class="hover:text-[#b91c1c] transition-colors duration-200">Autores</a>
            </div>
        </div>

        <div class="flex items-center gap-6 text-sm font-medium w-full sm:w-auto justify-center sm:justify-end">
            @auth
                @role('admin')
                <a href="{{ route('filament.admin.pages.dashboard') }}" class="text-slate-200 hover:text-[#b91c1c] transition-colors duration-200 font-semibold">
                    Painel (Admin)
                </a>
            @else
                <a href="{{ route('filament.reader.pages.dashboard') }}" class="text-slate-200 hover:text-[#b91c1c] transition-colors duration-200 font-semibold">
                    Minha Biblioteca
                </a>
                @endrole

                <form action="{{ route('logout') }}" method="post" class="m-0">
                    @csrf
                    <button type="submit" class="text-slate-500 hover:text-slate-300 transition text-xs font-semibold uppercase tracking-wider">
                        Sair
                    </button>
                </form>
                @else
                    <a href="{{ route('login') }}" class="text-slate-300 hover:text-white transition">Entrar</a>
                    <a href="{{ route('register') }}" class="bg-[#b91c1c] text-white px-4 py-2 rounded-lg font-semibold hover:bg-[#991b1b] transition shadow-md text-xs uppercase tracking-wider">
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
