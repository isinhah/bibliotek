<x-layout title="Livros em {{ $category->name }} — Bibliotek">

    <div class="mb-6">
        <x-alert />
    </div>

    <header class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-6 border-b border-slate-100">
        <div>
            <a href="{{ route('categories.public') }}" class="text-sm font-semibold text-slate-500 hover:text-[#b91c1c] transition-colors duration-150 flex items-center gap-1">
                ← Voltar para Categorias
            </a>
            <h1 class="text-3xl sm:text-4xl font-black text-slate-950 tracking-tighter mt-2 flex items-center gap-3">
                <span class="w-1.5 h-8 bg-[#b91c1c] rounded-full"></span>
                <span class="capitalize">{{ $category->name }}</span>
            </h1>
        </div>

        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 bg-slate-100 px-3 py-1.5 rounded-xl border border-slate-200/40">
            Total: {{ $books->total() }} {{ $books->total() === 1 ? 'livro' : 'livros' }}
        </span>
    </header>

    <div class="mb-14 max-w-xl">
        <form action="{{ route('categories.books.index', $category->id) }}" method="GET" class="relative group">
            <input
                type="text"
                name="search"
                value="{{ $searchTerm }}"
                placeholder="Pesquisar nesta categoria..."
                class="w-full pl-6 pr-12 py-3.5 bg-white border border-slate-200 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#b91c1c] transition-all text-sm text-slate-800"
            >
            @if(!empty($searchTerm))
                <a href="{{ route('categories.books.index', $category->id) }}" class="absolute right-10 top-3.5 text-slate-400 hover:text-slate-600 text-sm transition">
                    ✕
                </a>
            @endif
            <button type="submit" class="absolute right-4 top-3.5 text-slate-400 hover:text-[#b91c1c] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </button>
        </form>

        @if(!empty($searchTerm))
            <div class="text-xs text-slate-400 font-medium mt-2 pl-2">
                Encontrado(s) {{ $books->total() }} livro(s) para "{{ $searchTerm }}"
            </div>
        @endif
    </div>

    @if($books->isEmpty())
        <div class="bg-white p-16 rounded-2xl shadow-sm text-center border border-slate-100 text-slate-500 text-sm">
            Nenhum livro encontrado nesta categoria.
        </div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-3 gap-6">
            @foreach($books as $book)
                <x-book-card :book="$book" />
            @endforeach
        </div>

        <div class="mt-12">
            {{ $books->links('pagination::simple-tailwind') }}
        </div>
    @endif
</x-layout>
