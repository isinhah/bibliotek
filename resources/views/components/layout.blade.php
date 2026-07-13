<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans text-gray-900 antialiased min-h-screen flex flex-col">

    <nav class="bg-slate-950 text-slate-100 border-slate-900 shadow-lg relative z-50">
        <div class="container mx-auto px-6 py-4 flex flex-col sm:flex-row justify-between items-center gap-4">

            <div class="flex items-center gap-8 w-full sm:w-auto">
                <a href="/" class="text-2xl sm:text-3xl font-bold tracking-tight text-white transition duration-200">
                    Bibliotek<span class="text-[#b91c1c]">.</span>
                </a>
                <div class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-400">
                    <a href="{{ route('categories.public') }}" class="hover:text-[#b91c1c] transition-colors duration-200">Categorias</a>
                    <a href="{{ route('authors.index') }}" class="hover:text-[#b91c1c] transition-colors duration-200">Autores</a>
                </div>
            </div>

            <div class="flex items-center gap-2 text-sm font-medium w-full sm:w-auto justify-center sm:justify-end">
                @auth
                    @role('admin')
                    <a href="{{ route('filament.admin.pages.dashboard') }}"
                       class="flex items-center gap-1.5 text-slate-300 hover:text-white bg-slate-900 hover:bg-slate-800 px-3 py-1.5 rounded-lg transition-colors duration-200">
                        <x-heroicon-o-squares-2x2 class="w-4 h-4"/>
                        <span>Painel</span>
                    </a>
                @else
                    <a href="{{ route('filament.reader.pages.dashboard') }}"
                       class="flex items-center gap-1.5 text-slate-300 hover:text-white bg-slate-900 hover:bg-slate-800 px-3 py-1.5 rounded-lg transition-colors duration-200">
                        <x-heroicon-o-book-open class="w-4 h-4"/>
                        <span>Minha Biblioteca</span>
                    </a>

                    <div class="w-px h-4 bg-slate-700 mx-1"></div>

                    <a href="{{ route('filament.reader.resources.reading-list.index') }}"
                       title="Lista de Leitura"
                       class="text-slate-400 hover:text-white transition-colors duration-200 p-1.5 rounded-lg hover:bg-slate-900 flex items-center">
                        <x-heroicon-o-bookmark class="w-5 h-5"/>
                    </a>
                    @endrole

                    <a href="{{ auth()->user()->hasRole('admin') ? '/admin/profile' : '/reader/profile' }}"
                       title="Perfil"
                       class="text-slate-400 hover:text-white transition-colors duration-200 p-1.5 rounded-lg hover:bg-slate-800">
                        <x-heroicon-o-user class="w-5 h-5"/>
                    </a>

                    <form action="{{ route('logout') }}" method="post" class="m-0 flex items-center">
                        @csrf
                        <button type="submit"
                                title="Sair da Conta"
                                class="text-slate-400 hover:text-rose-400 transition-colors duration-200 p-1.5 rounded-lg hover:bg-slate-800">
                            <x-heroicon-o-arrow-left-on-rectangle class="w-5 h-5"/>
                        </button>
                    </form>
                    @else
                        <a href="{{ route('login') }}"
                           class="text-slate-300 hover:text-white transition-colors duration-200 px-3 py-1.5">
                            Entrar
                        </a>
                        <a href="{{ route('register') }}"
                           class="bg-[#b91c1c] hover:bg-[#991b1b] text-white text-xs font-semibold tracking-wider px-4 py-2 rounded-lg transition-colors duration-200">
                            Criar conta
                        </a>
                    @endauth
            </div>
        </div>
    </nav>

    @if(isset($isHome) && $isHome)
        {{ $slot }}
    @else
        <main class="container mx-auto my-8 px-6 flex-1">
            {{ $slot }}
        </main>
    @endif

</body>
</html>
