<x-layout title="Bibliotek">

    <div class="mb-10 text-center sm:text-left">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
            Descubra sua próxima leitura!
        </h1>
        <p class="text-slate-500 text-sm sm:text-base mt-2 max-w-xl">
            Explore nosso acervo completo e viaje por novas histórias.
        </p>
    </div>

    <div class="mb-6">
        <x-alert />
    </div>

    <div class="mb-12 max-w-2xl bg-white p-2 rounded-xl shadow-sm border border-slate-100 flex flex-col sm:flex-row items-center gap-3">
        <form action="{{ route('home') }}" method="GET" class="w-full flex gap-2 m-0">
            <div class="relative flex-1">
                <input
                    type="text"
                    name="search"
                    value="{{ $searchTerm }}"
                    placeholder="Pesquise por título em todo o acervo..."
                    class="w-full pl-4 pr-10 py-2.5 border-none rounded-lg text-sm focus:outline-none text-slate-700 bg-transparent"
                >
                @if(!empty($searchTerm))
                    <a href="{{ route('home') }}" class="absolute right-3 top-3 text-slate-400 hover:text-slate-600 text-sm transition">
                        ✕
                    </a>
                @endif
            </div>
            <button type="submit" class="w-full sm:w-auto bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold px-6 py-2.5 rounded-lg transition duration-150 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-sm">
                Buscar
            </button>
        </form>

        @if(!empty($searchTerm))
            <div class="text-xs text-slate-400 font-mono px-3 whitespace-nowrap border-l border-slate-100 hidden sm:inline">
                {{ $searchResults->total() }} resultado(s)
            </div>
        @endif
    </div>

    @if(!empty($searchTerm))
        <div class="flex items-center justify-between mb-6 pb-2 border-b border-slate-100">
            <h2 class="text-lg font-bold text-slate-800">Resultados para: <span class="text-emerald-600">"{{ $searchTerm }}"</span></h2>
            <a href="{{ route('home') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition">Limpar busca</a>
        </div>

        @if($searchResults->isEmpty())
            <div class="bg-white p-16 rounded-xl shadow-sm text-center border border-slate-100 text-slate-500 text-sm">
                Nenhum livro encontrado em todo o acervo com o termo solicitado.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($searchResults as $book)
                    <x-book-card :book="$book" />
                @endforeach
            </div>
            <div class="mt-10">
                {{ $searchResults->links('pagination::simple-tailwind') }}
            </div>
        @endif

    @else
        <div class="space-y-12">
            @foreach($categoriesWithBooks as $category)
                <div class="bg-white p-6 rounded-xl border border-slate-100/80 shadow-xs">

                    <div class="flex justify-between items-center mb-5 pb-3 border-b border-slate-50">
                        <div class="flex items-center gap-2">
                            <div class="w-1.5 h-5 bg-emerald-500 rounded-full"></div>
                            <h2 class="text-lg font-bold text-slate-800 capitalize tracking-tight">
                                {{ $category->name }}
                            </h2>
                        </div>
                        <a href="{{ route('categories.books.index', $category->id) }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100/80 px-2.5 py-1 rounded-md transition duration-150">
                            Ver todos →
                        </a>
                    </div>

                    <div class="flex gap-5 overflow-x-auto pb-2 pt-1 snap-x no-scrollbar scroll-smooth" style="scrollbar-width: thin;">
                        @foreach($category->books as $book)
                            <div class="w-[290px] sm:w-[310px] flex-shrink-0 snap-start">
                                <x-book-card :book="$book" />
                            </div>
                        @endforeach
                    </div>

                </div>
            @endforeach
        </div>
    @endif

</x-layout>
