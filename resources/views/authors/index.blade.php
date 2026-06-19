<x-layout title="Autores — Bibliotek">

    <header class="mb-12 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
        <div>
            <h1 class="text-3xl sm:text-4xl font-black text-slate-950 tracking-tighter">
                Escritores e Autores
            </h1>
            <p class="text-slate-500 mt-2 max-w-xl text-base">
                Conheça os escritores e autores disponíveis no nosso acervo.
            </p>
        </div>

        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 bg-slate-100 px-3 py-1.5 rounded-xl border border-slate-200/40">
            Total: {{ $authors->total() }} autores
        </span>
    </header>

    <div class="mb-14 space-y-6">
        <div class="max-w-xl">
            <form action="{{ route('authors.index') }}" method="GET" class="relative group m-0">
                @if(!empty($selectedLetter))
                    <input type="hidden" name="letter" value="{{ $selectedLetter }}">
                @endif
                <input
                    type="text"
                    name="search"
                    value="{{ $searchTerm }}"
                    placeholder="Pesquisar autor por nome..."
                    class="w-full pl-6 pr-12 py-3.5 bg-white border border-slate-200 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#b91c1c] transition-all text-sm text-slate-800"
                >
                @if(!empty($searchTerm))
                    <a href="{{ route('authors.index', ['letter' => $selectedLetter]) }}" class="absolute right-10 top-3.5 text-slate-400 hover:text-slate-600 text-sm transition">
                        ✕
                    </a>
                @endif
                <button type="submit" class="absolute right-4 top-3.5 text-slate-400 hover:text-[#b91c1c] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>
            </form>
        </div>

        <div class="flex flex-wrap gap-1.5 pb-2 border-b border-slate-100">
            <a href="{{ route('authors.index', ['search' => $searchTerm]) }}"
               class="px-3 py-1.5 rounded-xl text-xs font-semibold transition {{ empty($selectedLetter) ? 'bg-slate-950 text-white' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900' }}">
                Todos
            </a>
            @foreach(range('A', 'Z') as $char)
                <a href="{{ route('authors.index', ['letter' => $char, 'search' => $searchTerm]) }}"
                   class="w-8 h-8 flex items-center justify-center rounded-xl text-xs font-semibold transition {{ $selectedLetter === $char ? 'bg-[#b91c1c] text-white' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900' }}">
                    {{ $char }}
                </a>
            @endforeach
        </div>
    </div>

    @if($authors->isEmpty())
        <div class="bg-white p-16 rounded-2xl shadow-sm text-center border border-slate-100 text-slate-500 text-sm">
            Nenhum escritor encontrado com os critérios selecionados.
            @if(!empty($searchTerm) || !empty($selectedLetter))
                <a href="{{ route('authors.index') }}" class="block mt-3 text-sm font-semibold text-[#b91c1c] hover:underline">
                    Limpar todos os filtros
                </a>
            @endif
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($authors as $author)
                <a href="{{ route('authors.books.index', $author->id) }}"
                   class="group bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:border-slate-200/60 transition-all duration-300 flex justify-between items-center">

                    <div class="space-y-1 min-w-0">
                        <h3 class="font-bold text-slate-900 group-hover:text-[#b91c1c] transition-colors duration-200 capitalize text-lg tracking-tight truncate">
                            {{ $author->name }}
                        </h3>
                        <span class="inline-flex items-center text-xs font-medium text-slate-400">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 mr-2 group-hover:bg-[#b91c1c] transition-colors duration-200"></span>
                            {{ $author->books_count }} {{ $author->books_count === 1 ? 'livro no acervo' : 'livros no acervo' }}
                        </span>
                    </div>

                    <span class="text-slate-300 group-hover:text-[#b91c1c] group-hover:translate-x-1 transform text-xl font-light transition-all duration-200 pl-4">
                        →
                    </span>
                </a>
            @endforeach
        </div>

        @if($authors->hasPages())
            <div class="mt-12">
                {{ $authors->links('pagination::simple-tailwind') }}
            </div>
        @endif
    @endif
</x-layout>
