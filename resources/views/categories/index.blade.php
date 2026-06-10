<x-layout title="Categorias">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Explore por Gênero</h1>
        <p class="text-slate-500 text-sm mt-1">Encontre livros divididos pelos seus assuntos favoritos.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($categories as $category)
            <a href="{{ route('categories.books.index', $category->id) }}" class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:border-emerald-500 hover:shadow-md transition flex justify-between items-center group">
                <div>
                    <h3 class="font-semibold text-slate-800 group-hover:text-emerald-600 transition capitalize text-lg">
                        {{ $category->name }}
                    </h3>
                    <span class="text-xs text-slate-400">
                        {{ $category->books_count }} {{ $category->books_count === 1 ? 'livro' : 'livros' }} disponível(is)
                    </span>
                </div>
                <span class="text-slate-300 group-hover:text-emerald-500 text-xl transition">→</span>
            </a>
        @endforeach
    </div>
</x-layout>
