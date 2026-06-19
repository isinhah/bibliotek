<x-layout title="Livros de {{ $author->name }} — Bibliotek">

    <div class="mb-6">
        <x-alert />
    </div>

    <header class="mb-12 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 pb-6 border-b border-slate-100">
        <div>
            <a href="{{ route('authors.index') }}" class="text-sm font-semibold text-slate-500 hover:text-[#b91c1c] transition-colors duration-150 flex items-center gap-1">
                ← Voltar para Autores
            </a>
            <h1 class="text-3xl sm:text-4xl font-black text-slate-950 tracking-tighter mt-2 flex items-center gap-3">
                <span class="w-1.5 h-8 bg-[#b91c1c] rounded-full"></span>
                <span class="capitalize">{{ $author->name }}</span>
            </h1>
        </div>

        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 bg-slate-100 px-3 py-1.5 rounded-xl border border-slate-200/40">
            {{ $books->count() }} {{ $books->count() === 1 ? 'obra disponível' : 'obras disponíveis' }}
        </span>
    </header>

    @if($books->isEmpty())
        <div class="bg-white p-16 rounded-2xl shadow-sm text-center border border-slate-100 text-slate-500 text-sm">
            Nenhum livro encontrado para este autor no momento.
        </div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-3 gap-6">
            @foreach($books as $book)
                <x-book-card :book="$book" />
            @endforeach
        </div>
    @endif
</x-layout>
