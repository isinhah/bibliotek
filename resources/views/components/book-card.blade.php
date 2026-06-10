@props(['book'])

<div class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition duration-200">
    <div class="p-4 flex gap-4">
        <div class="w-24 h-36 bg-gray-50 flex-shrink-0 rounded-lg overflow-hidden shadow-sm border border-gray-100">
            @if($book->cover_id)
                <img src="https://covers.openlibrary.org/b/id/{{ $book->cover_id }}-M.jpg"
                     alt="Capa do livro {{ $book->title }}"
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex flex-col items-center justify-center bg-gray-100 text-gray-400 p-2 text-center">
                    <span class="text-[10px] font-bold uppercase tracking-wider">Sem Capa</span>
                </div>
            @endif
        </div>

        <div class="flex flex-col justify-between py-1 flex-1">
            <div>
                <h3 class="font-bold text-slate-800 text-base leading-tight mt-0.5" title="{{ $book->title }}">
                    {{ Str::limit($book->title, 40) }}
                </h3>
                <p class="text-sm text-slate-500 mt-1">
                    Autor: <span class="font-medium text-slate-700">{{ $book->author->name }}</span>
                </p>
            </div>

            <div class="flex flex-wrap gap-1.5 items-center">
                @if($book->stock > 0)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                        Estoque: {{ $book->stock }}
                    </span>
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-600 border border-red-100">
                        Esgotado
                    </span>
                @endif

                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100 capitalize">
                    {{ $book->category?->name ?? 'Sem Categoria' }}
                </span>
            </div>
        </div>
    </div>

    <div class="bg-slate-50 px-4 py-3 border-t border-gray-100 flex justify-between gap-2 items-center">
        <div class="flex items-center gap-3">
            @auth
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('books.edit', $book->id) }}" class="text-xs text-slate-400 hover:text-emerald-600 font-medium transition">
                        Editar Estoque
                    </a>
                @endif
            @endauth
        </div>

        <div>
            @if($book->stock > 0)
                <form action="{{ route('loans.store', $book->id) }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="inline-flex items-center bg-slate-900 hover:bg-slate-800 text-white font-medium py-1.5 px-4 rounded-lg text-sm transition focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-sm">
                        Pedir Emprestado
                    </button>
                </form>
            @else
                <button disabled class="inline-flex items-center bg-gray-200 text-gray-400 font-medium py-1.5 px-4 rounded-lg text-sm cursor-not-allowed">
                    Esgotado
                </button>
            @endif
        </div>
    </div>
</div>
