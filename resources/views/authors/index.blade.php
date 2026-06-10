<x-layout title="Autores">

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Autores</h1>
            <p class="text-gray-500 text-sm mt-1">Conheça os escritores disponíveis no nosso acervo.</p>
        </div>

        <span class="text-xs text-gray-500 bg-gray-100 px-3 py-1 rounded-full font-medium border border-gray-200/60">
            Total: {{ $authors->total() }} autores
        </span>
    </div>

    <div class="mb-4 bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <form action="{{ route('authors.index') }}" method="GET" class="w-full sm:max-w-md flex gap-2 m-0">
            @if(!empty($selectedLetter))
                <input type="hidden" name="letter" value="{{ $selectedLetter }}">
            @endif
            <div class="relative flex-1">
                <input
                    type="text"
                    name="search"
                    value="{{ $searchTerm }}"
                    placeholder="Pesquisar por nome do autor..."
                    class="w-full pl-3 pr-10 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 text-gray-700 bg-transparent border-gray-200"
                >
                @if(!empty($searchTerm))
                    <a href="{{ route('authors.index', request()->except('search')) }}" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600 text-sm">
                        ✕
                    </a>
                @endif
            </div>
            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold px-4 py-2 rounded-lg transition shadow-sm">
                Buscar
            </button>
        </form>

        <div class="text-xs text-gray-400 font-medium">
            @if(!empty($searchTerm))
                Encontrado(s) {{ $authors->total() }} autor(es) para "{{ $searchTerm }}"
            @endif
        </div>
    </div>

    <div class="mb-6 bg-white p-3 rounded-xl shadow-sm border border-gray-100 flex flex-wrap gap-1 items-center justify-center">
        <a href="{{ route('authors.index', request()->except('letter')) }}"
           class="px-3 py-1 text-xs font-bold rounded-lg transition {{ empty($selectedLetter) ? 'bg-slate-900 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
            Todos
        </a>

        @foreach($alphabet as $letter)
            <a href="{{ route('authors.index', array_merge(request()->query(), ['letter' => $letter, 'page' => 1])) }}"
               class="w-7 h-7 flex items-center justify-center text-xs font-bold rounded-lg transition {{ $selectedLetter === $letter ? 'bg-slate-900 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                {{ $letter }}
            </a>
        @endforeach
    </div>

    @if($authors->isEmpty())
        <div class="bg-white p-12 rounded-xl shadow-sm text-center border border-gray-100 text-gray-500 text-sm">
            Nenhum autor encontrado.
            <div class="mt-2">
                <a href="{{ route('authors.index') }}" class="text-sm font-bold text-slate-700 hover:text-slate-900 underline">Limpar todos os filtros</a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($authors as $author)
                <a href="{{ route('authors.books.index', $author->id) }}" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:border-slate-400/70 transition flex justify-between items-center group">
                    <div>
                        <h3 class="font-bold text-slate-800 group-hover:text-slate-900 transition capitalize">
                            {{ $author->name }}
                        </h3>
                        <span class="text-xs text-gray-400 block mt-0.5">
                            {{ $author->books_count }} {{ $author->books_count === 1 ? 'livro' : 'livros' }} no acervo
                        </span>
                    </div>
                    <span class="text-gray-300 group-hover:text-slate-800 font-bold text-base transition transform group-hover:translate-x-0.5">→</span>
                </a>
            @endforeach
        </div>

        @if($authors->hasPages())
            <div class="mt-8 bg-white p-4 rounded-xl border border-gray-100 shadow-sm [&_nav]:flex [&_nav]:justify-between [&_a]:bg-white [&_a]:text-slate-700 [&_a]:border-gray-200 [&_a]:hover:bg-gray-50 [&_span]:bg-slate-900 [&_span]:text-white [&_span]:border-slate-900">
                {{ $authors->links() }}
            </div>
        @endif
    @endif
</x-layout>
