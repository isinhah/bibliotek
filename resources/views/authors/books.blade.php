<x-layout title="Livros de {{ $author->name }}">

    <div class="mb-6">
        <a href="{{ route('authors.index') }}" class="text-sm font-semibold text-slate-500 hover:text-emerald-600 flex items-center gap-1.5 transition duration-150 group w-fit">
            <span class="inline-block transform group-hover:-translate-x-0.5 transition duration-150">←</span> Voltar para Autores
        </a>
        <h1 class="text-2xl font-bold text-slate-800 mt-3">
            Livros do Autor: <span class="capitalize text-slate-950">{{ $author->name }}</span>
        </h1>
    </div>

    <div class="mb-6">
        <x-alert />
    </div>

    @if($books->isEmpty())
        <div class="bg-white p-16 rounded-xl shadow-sm text-center border border-slate-100 text-slate-500 text-sm">
            Nenhum livro encontrado para este autor no momento.
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($books as $book)
                <x-book-card :book="$book" />
            @endforeach
        </div>

        <div class="mt-8 bg-white p-4 rounded-xl border border-slate-100 shadow-sm [&_nav]:flex [&_nav]:justify-between [&_a]:bg-white [&_a]:text-slate-700 [&_a]:border-slate-200 [&_a]:hover:bg-slate-50 [&_span]:bg-slate-900 [&_span]:text-white [&_span]:border-slate-900">
            {{ $books->links() }}
        </div>
    @endif
</x-layout>
