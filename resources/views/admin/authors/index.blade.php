<x-layout title="Painel de Autores">
    <div class="flex flex-col gap-6 w-full max-w-5xl mx-auto">

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 w-full">
            @php
                $editId = request('edit');

                if (!$editId && session()->get('errors')) {
                    $previousUrl = url()->previous();

                    if (preg_match('/authors\/(\d+)/', $previousUrl, $matches)) {
                        $editId = $matches[1];
                    }
                }

                $editingAuthor = $editId ? $authors->firstWhere('id', $editId) : null;
            @endphp

            @if($editingAuthor)
                <h2 class="text-xl font-bold mb-4 text-slate-800">Editar Autor</h2>
                <form action="{{ route('admin.authors.update', $editingAuthor->id) }}" method="POST" class="m-0">
                    @csrf
                    @method('PUT')

                    <div class="mb-4 max-w-md">
                        <label class="block text-slate-700 text-sm font-semibold mb-2">Nome do Autor</label>
                        <input type="text" name="name" value="{{ old('name', $editingAuthor->name) }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 text-slate-700 @error('name') border-red-500 @enderror" required>
                        @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex gap-3 items-center">
                        <x-button variant="primary">Salvar Edição</x-button>
                        <a href="{{ route('admin.authors.index', ['search' => request('search')]) }}" class="text-sm text-slate-500 hover:text-slate-700 transition">Cancelar</a>
                    </div>
                </form>
            @else
                <h2 class="text-xl font-bold mb-4 text-slate-800">Novo Autor</h2>
                <form action="{{ route('admin.authors.store') }}" method="POST" class="m-0">
                    @csrf

                    <div class="flex flex-col sm:flex-row gap-4 items-end max-w-xl">
                        <div class="flex-1 w-full">
                            <label class="block text-slate-700 text-sm font-semibold mb-2">Nome do Autor</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Ex: J.K. Rowling, George R.R. Martin" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 text-slate-700 @error('name') border-red-500 @enderror" required>
                        </div>
                        <div class="mb-[2px]">
                            <x-button variant="primary" class="h-[42px] px-6">Criar Autor</x-button>
                        </div>
                    </div>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                    <div class="mt-4 max-w-xl">
                        <x-alert />
                    </div>
                </form>
            @endif
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 w-full">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 pb-4 border-b border-gray-100">
                <div>
                    <h2 class="text-xl font-bold text-slate-800">Lista de Autores</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Gerencie os escritores do acervo literário</p>
                </div>

                <form action="{{ route('admin.authors.index') }}" method="GET" class="w-full sm:max-w-xs flex gap-2">
                    <div class="relative flex-1">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Buscar por nome..."
                            class="w-full pl-3 pr-8 py-1.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 text-slate-700"
                        >
                        @if(request('search'))
                            <a href="{{ route('admin.authors.index') }}" class="absolute right-2.5 top-2 text-slate-400 hover:text-slate-600 text-sm">
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

            @if($authors->isEmpty())
                <p class="text-slate-500 text-center py-8">Nenhum autor cadastrado ou encontrado com esse nome.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                        <tr class="border-b border-gray-100 bg-slate-50 text-slate-600 font-bold text-xs uppercase tracking-wider">
                            <th class="p-3 w-16">ID</th>
                            <th class="p-3">Nome</th>
                            <th class="p-3 text-right">Ações</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                        @foreach($authors as $author)
                            <tr class="hover:bg-slate-50/50 transition duration-150">
                                <td class="p-3 text-slate-400 font-mono text-xs">{{ $author->id }}</td>
                                <td class="p-3 font-semibold text-slate-800 capitalize">{{ $author->name }}</td>
                                <td class="p-3 flex items-center justify-end gap-2">

                                    <a href="{{ route('authors.books.index', $author->id) }}" class="inline-flex items-center bg-slate-900 hover:bg-slate-800 text-white font-medium py-1 px-3 rounded-lg text-xs shadow-xs transition h-[34px] focus:outline-none focus:ring-2 focus:ring-slate-500">
                                        Ver Livros
                                    </a>

                                    <a href="?edit={{ $author->id }}{{ request('search') ? '&search=' . request('search') : '' }}" class="inline-flex items-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium py-1 px-3 rounded-lg text-xs border border-slate-200/60 transition h-[34px] focus:outline-none">
                                        Editar
                                    </a>

                                    <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este autor?')" class="flex items-center m-0">
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

                @if($authors->hasPages())
                    <div class="mt-6 [&_nav]:flex [&_nav]:justify-between [&_a]:bg-white [&_a]:text-slate-700 [&_a]:border-slate-200 [&_a]:hover:bg-slate-50 [&_span]:bg-slate-900 [&_span]:text-white [&_span]:border-slate-900">
                        {{ $authors->appends(['search' => request('search')])->links() }}
                    </div>
                @endif
            @endif
        </div>

    </div>
</x-layout>
