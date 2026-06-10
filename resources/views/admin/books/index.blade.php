<x-layout title="Painel de Livros">
    <div class="flex flex-col gap-6 w-full max-w-5xl mx-auto">

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 w-full">
            @php
                $editId = request('edit');
                $editingBook = $editId ? $books->firstWhere('id', $editId) : null;
            @endphp

            @if($editingBook)
                <h2 class="text-xl font-bold mb-4 text-slate-800">Editar Livro</h2>
                <form action="{{ route('admin.books.update', $editingBook->id) }}" method="POST" class="m-0">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-3xl mb-4">
                        <div>
                            <label class="block text-slate-700 text-sm font-semibold mb-1">Título</label>
                            <input type="text" name="title" value="{{ old('title', $editingBook->title) }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 text-slate-700" required>
                        </div>

                        <div>
                            <label class="block text-slate-700 text-sm font-semibold mb-1">Quantidade em Estoque</label>
                            <input type="number" name="stock" value="{{ old('stock', $editingBook->stock) }}" min="0" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 text-slate-700" required>
                        </div>

                        <div>
                            <label class="block text-slate-700 text-sm font-semibold mb-1">Autor</label>
                            <select name="author_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 text-slate-700 bg-white" required>
                                <option value="">Selecione o Autor</option>
                                @foreach($authors as $author)
                                    <option value="{{ $author->id }}" {{ old('author_id', $editingBook->author_id) == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-slate-700 text-sm font-semibold mb-1">Categoria</label>
                            <select name="category_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 text-slate-700 bg-white" required>
                                <option value="">Selecione a Categoria</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $editingBook->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex gap-3 items-center">
                        <x-button variant="primary">Atualizar Livro</x-button>
                        <a href="{{ route('admin.books.index') }}" class="text-sm text-slate-500 hover:text-slate-700 transition">Cancelar</a>
                    </div>
                </form>
            @else
                <h2 class="text-xl font-bold mb-4 text-slate-800">Novo Livro</h2>
                <form action="{{ route('admin.books.store') }}" method="POST" class="m-0">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-3xl mb-4">
                        <div>
                            <label class="block text-slate-700 text-sm font-semibold mb-1">Título</label>
                            <input type="text" name="title" value="{{ old('title') }}" placeholder="Ex: O Senhor dos Anéis" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 text-slate-700" required>
                        </div>

                        <div>
                            <label class="block text-slate-700 text-sm font-semibold mb-1">Quantidade em Estoque</label>
                            <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 text-slate-700" required>
                        </div>

                        <div>
                            <label class="block text-slate-700 text-sm font-semibold mb-1">Autor</label>
                            <select name="author_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 text-slate-700 bg-white" required>
                                <option value="">Selecione o Autor</option>
                                @foreach($authors as $author)
                                    <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-slate-700 text-sm font-semibold mb-1">Categoria</label>
                            <select name="category_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 text-slate-700 bg-white" required>
                                <option value="">Selecione a Categoria</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <x-button variant="primary" class="px-6">Cadastrar Livro</x-button>

                    <div class="mt-4 max-w-3xl">
                        <x-alert />
                    </div>
                </form>
            @endif
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 w-full">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 pb-4 border-b border-gray-100">
                <div>
                    <h2 class="text-xl font-bold text-slate-800">Lista de Livros</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Gerencie os livros e o estoque</p>
                </div>

                <form action="{{ route('admin.books.index') }}" method="GET" class="w-full sm:max-w-xs flex gap-2">
                    <div class="relative flex-1">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Buscar por título..."
                            class="w-full pl-3 pr-8 py-1.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 text-slate-700"
                        >
                        @if(request('search'))
                            <a href="{{ route('admin.books.index') }}" class="absolute right-2.5 top-2 text-slate-400 hover:text-slate-600 text-sm">
                                ✕
                            </a>
                        @endif
                    </div>
                    <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white text-xs font-medium px-4 py-1.5 rounded-lg transition shadow-sm">
                        Buscar
                    </button>
                </form>
            </div>

            @if(request('search'))
                <p class="text-sm text-slate-500 mb-4">
                    Resultados encontrados para: <span class="font-semibold text-slate-800">"{{ request('search') }}"</span>
                </p>
            @endif

            @if($books->isEmpty())
                <p class="text-slate-500 text-center py-8">Nenhum livro cadastrado ou encontrado com esse nome.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                        <tr class="border-b border-gray-100 bg-slate-50 text-slate-600 font-bold text-xs uppercase tracking-wider">
                            <th class="p-3 w-16">ID</th>
                            <th class="p-3">Título</th>
                            <th class="p-3">Autor</th>
                            <th class="p-3">Categoria</th>
                            <th class="p-3 w-24 text-center">Estoque</th>
                            <th class="p-3 text-right">Ações</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                        @foreach($books as $book)
                            <tr class="hover:bg-slate-50/50 transition duration-150">
                                <td class="p-3 text-slate-400 font-mono text-xs">{{ $book->id }}</td>
                                <td class="p-3 font-semibold text-slate-800">{{ $book->title }}</td>
                                <td class="p-3 text-slate-600">{{ $book->author->name }}</td>
                                <td class="p-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100 capitalize">
                                        {{ $book->category?->name ?? 'Sem Categoria' }}
                                    </span>
                                </td>
                                <td class="p-3 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $book->stock > 0 ? 'bg-green-50 text-green-700 border border-green-100' : 'bg-red-50 text-red-600 border border-red-100' }}">
                                        {{ $book->stock }}
                                    </span>
                                </td>
                                <td class="p-3 flex items-center justify-end gap-2">
                                    <a href="?edit={{ $book->id }}{{ request('search') ? '&search=' . request('search') : '' }}" class="inline-flex items-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium py-1 px-3 rounded-lg text-xs border border-slate-200/60 transition h-[34px] focus:outline-none">
                                        Editar
                                    </a>

                                    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir o livro \'{{ $book->title }}\'?')" class="flex items-center m-0">
                                        @csrf
                                        @method('DELETE')
                                        <x-button variant="danger" class="h-[34px] !text-xs !py-1 flex items-center justify-center">Excluir</x-button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 [&_nav]:flex [&_nav]:justify-between [&_a]:bg-white [&_a]:text-slate-700 [&_a]:border-slate-200 [&_a]:hover:bg-slate-50 [&_span]:bg-slate-900 [&_span]:text-white [&_span]:border-slate-900">
                    {{ $books->appends(['search' => request('search')])->links() }}
                </div>
            @endif
        </div>

    </div>
</x-layout>
