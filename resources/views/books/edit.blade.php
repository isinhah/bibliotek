<x-layout title="Editar Estoque - {{ $book->title }}">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-sm border border-gray-100">

        <div class="mb-6">
            <a href="{{ route('categories.books.index', $book->category_id) }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-semibold">
                ← Voltar para os Livros
            </a>
            <h1 class="text-2xl font-bold text-slate-800 mt-2">Atualizar Estoque do Livro</h1>
        </div>

        <div class="flex gap-4 bg-slate-50 p-4 rounded-xl border border-slate-100 mb-6">
            <div class="w-16 h-24 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0 shadow-xs border border-gray-100">
                @if($book->cover_id)
                    <img src="https://covers.openlibrary.org/b/id/{{ $book->cover_id }}-M.jpg" class="w-full h-full object-cover">
                @endif
            </div>
            <div>
                <h3 class="font-bold text-slate-800 text-base">{{ $book->title }}</h3>
                <p class="text-sm text-slate-600">Autor: {{ $book->author->name }}</p>
                <p class="text-xs text-slate-400 font-mono mt-1">ID API: {{ $book->isbn }}</p>
                <span class="inline-block mt-2 text-xs bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full font-medium border border-emerald-100 capitalize">
                    Categoria: {{ $book->category->name }}
                </span>
            </div>
        </div>

        <form action="{{ route('books.update', $book->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="stock" class="block text-slate-700 text-sm font-bold mb-2">
                    Quantidade em Estoque
                </label>
                <input
                    type="number"
                    id="stock"
                    name="stock"
                    value="{{ old('stock', $book->stock) }}"
                    min="0"
                    class="w-full max-w-xs px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 text-slate-700 @error('stock') border-red-500 @enderror"
                    required
                >
                @error('stock')
                <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                @enderror
                <p class="text-slate-400 text-xs mt-1">Altere o valor para definir quantos livros físicos estão disponíveis para novos empréstimos.</p>
            </div>

            <div class="flex items-center gap-4 border-t border-gray-100 pt-4">
                <x-button variant="primary">Salvar Alteração</x-button>
                <a href="{{ route('categories.books.index', $book->category_id) }}" class="text-sm text-slate-500 hover:text-slate-700 transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-layout>
