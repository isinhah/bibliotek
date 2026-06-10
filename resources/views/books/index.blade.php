<x-layout title="Livros em {{ $category->name }}">

    <div class="mb-4">
        <x-alert />
    </div>

    <div class="mb-6 flex justify-between items-center">
        <div>
            <a href="{{ route('categories.public') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-semibold flex items-center gap-1">
                ← Voltar para Categorias
            </a>
            <h1 class="text-2xl font-bold text-slate-800 mt-1">Livros da Categoria: <span class="capitalize">{{ $category->name }}</span></h1>
        </div>

        <span class="text-sm text-slate-500 bg-slate-100 px-3 py-1 rounded-full font-medium border border-slate-200">
            Total: {{ $books->count() }} livros
        </span>
    </div>

    <div class="mb-6 bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <form action="{{ route('categories.books.index', $category->id) }}" method="GET" class="w-full sm:max-w-md flex gap-2">
            <div class="relative flex-1">
                <input
                    type="text"
                    name="search"
                    value="{{ $searchTerm }}"
                    placeholder="Pesquisar por título nesta categoria..."
                    class="w-full pl-3 pr-10 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 text-slate-700"
                >
                @if(!empty($searchTerm))
                    <a href="{{ route('categories.books.index', $category->id) }}" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600 text-sm">
                        ✕
                    </a>
                @endif
            </div>
            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                Buscar
            </button>
        </form>

        <div class="text-xs text-slate-400 font-medium">
            @if(!empty($searchTerm))
                Encontrado(s) {{ $books->total() }} livro(s) para "{{ $searchTerm }}"
            @endif
        </div>
    </div>

    @if($books->isEmpty())
        <div class="bg-white p-12 rounded-xl shadow-sm text-center border border-gray-100 text-slate-500">
            Nenhum livro cadastrado para esta categoria ainda.
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($books as $book)
                <x-book-card :book="$book" />
            @endforeach
        </div>

        <div class="mt-8 bg-white p-4 rounded-xl shadow-sm border border-gray-100 [&_nav]:flex [&_nav]:justify-between [&_a]:bg-white [&_a]:text-slate-700 [&_a]:border-slate-200 [&_a]:hover:bg-slate-50 [&_span]:bg-slate-900 [&_span]:text-white [&_span]:border-slate-900">
            {{ $books->links() }}
        </div>
    @endif
</x-layout>
