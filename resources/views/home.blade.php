<x-layout title="Bibliotek" :isHome="true">
    <div class="bg-slate-950 text-slate-100 shadow-lg pb-16 pt-16">

        <header class="text-center px-4">
            <h1 class="text-4xl md:text-5xl font-black text-white tracking-tighter">
                Bem vindo ao acervo.
            </h1>
            <p class="text-slate-400 mt-4 max-w-lg mx-auto text-lg">
                Explore a bibliotek e encontre sua próxima leitura.
            </p>
        </header>

        <div class="mt-10 max-w-xl mx-auto px-4">
            <form action="{{ route('home') }}" method="GET" class="relative group">
                <input
                    type="text"
                    name="search"
                    value="{{ $searchTerm }}"
                    placeholder="Pesquisar pelo título do livro..."
                    class="w-full pl-6 pr-12 py-4 bg-slate-900 border border-slate-800 rounded-2xl shadow-inner text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-[#b91c1c] focus:border-transparent transition-all"
                >
                <button type="submit" class="absolute right-4 top-4 text-slate-500 hover:text-[#b91c1c] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <div class="container mx-auto my-12 px-6 flex-1">
        <div class="max-w-xl mx-auto mb-6">
            <x-alert />
        </div>

        @if(!empty($searchTerm))
            <div class="mb-8 pb-4 border-b border-slate-200 flex items-center justify-between">
                <h2 class="text-xl font-bold text-slate-900">
                    Resultados para: <span class="text-[#b91c1c]">"{{ $searchTerm }}"</span>
                </h2>
                <a href="{{ route('home') }}" class="text-sm font-medium text-slate-500 hover:text-slate-950 transition">
                    Limpar busca
                </a>
            </div>

            @if($searchResults->isEmpty())
                <div class="bg-white p-16 rounded-2xl shadow-sm text-center border border-slate-100 text-slate-500 text-sm">
                    Nenhum livro encontrado em todo o acervo com esse termo.
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                    @foreach($searchResults as $book)
                        <x-book-card :book="$book" />
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $searchResults->links('pagination::simple-tailwind') }}
                </div>
            @endif

        @elseif(!empty($categoriesWithBooks))
            <div class="space-y-12">
                @foreach($categoriesWithBooks as $category)
                    <section>
                        <div class="flex items-center justify-between mb-4 px-2">
                            <h2 class="text-2xl font-black text-slate-950 tracking-tighter flex items-center">
                                <span class="capitalize">{{ $category->name }}</span><span class="text-[#b91c1c]">.</span>
                            </h2>
                            <a href="{{ route('categories.books.index', $category->id) }}"
                               class="text-sm font-semibold text-[#b91c1c] hover:underline underline-offset-4 transition">
                                Ver tudo →
                            </a>
                        </div>

                        <div class="flex gap-6 overflow-x-auto pb-5 pt-2 px-2 snap-x snap-mandatory scroll-smooth custom-scrollbar">
                            @foreach($category->books->take(9) as $book)
                                <div class="w-[280px] sm:w-[320px] md:w-[350px] flex-shrink-0 snap-start">
                                    <x-book-card :book="$book" />
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endforeach

                @if(method_exists($categoriesWithBooks, 'hasPages') && $categoriesWithBooks->hasPages())
                    <div class="mt-16 pt-6 border-t border-slate-200">
                        {{ $categoriesWithBooks->links('pagination::simple-tailwind') }}
                    </div>
                @endif
            </div>

            <style>
                .custom-scrollbar::-webkit-scrollbar {
                    height: 10px;
                }
                .custom-scrollbar::-webkit-scrollbar-track {
                    background: transparent;
                }
                .custom-scrollbar::-webkit-scrollbar-thumb {
                    background: #cbd5e1;
                    border-radius: 10px;
                    transition: background 0.2s ease;
                }
                .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                    background: #b91c1c;
                    cursor: grabbing;
                }
            </style>
        @endif
    </div>
</x-layout>
