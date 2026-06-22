@php use App\Services\ReadingListService; @endphp
@props(['book'])

<div class="group bg-white border border-slate-100 rounded-2xl p-4 sm:p-5 flex flex-col justify-between hover:shadow-xl hover:border-slate-200/60 transition-all duration-300 h-full">

    <div class="flex flex-col sm:flex-row gap-4 mb-5 items-center sm:items-start text-center sm:text-left">

        <div class="w-28 h-40 bg-slate-50 flex-shrink-0 rounded-xl overflow-hidden shadow-sm border border-slate-100 relative mx-auto sm:mx-0">
            @if($book->cover_id)
                @if(filter_var($book->cover_id, FILTER_VALIDATE_INT) || is_numeric($book->cover_id))
                    <img src="https://covers.openlibrary.org/b/id/{{ $book->cover_id }}-M.jpg"
                         alt="Capa do livro {{ $book->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                @else
                    <img src="{{ Storage::url($book->cover_id) }}"
                         alt="Capa do livro {{ $book->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                @endif
            @else
                <div class="w-full h-full flex flex-col items-center justify-center bg-slate-50 text-slate-400 p-2 text-center">
                    <span class="text-[9px] font-bold uppercase tracking-widest text-slate-400">Sem Capa</span>
                </div>
            @endif
        </div>

        <div class="flex flex-col justify-between py-0.5 flex-1 min-w-0 w-full h-full min-h-[160px] sm:min-h-0">
            <div class="mb-3 sm:mb-0">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1 capitalize">
                    {{ $book->category?->name ?? 'Geral' }}
                </span>
                <h3 class="font-bold text-slate-900 text-base leading-snug tracking-tight group-hover:text-[#b91c1c] transition-colors duration-200 line-clamp-3 sm:line-clamp-2" title="{{ $book->title }}">
                    {{ $book->title }}
                </h3>
                <p class="text-xs text-slate-500 mt-1 truncate">
                    por <span class="font-medium text-slate-800">{{ $book->author->name }}</span>
                </p>
            </div>

            <div class="flex justify-center sm:justify-start">
                @if($book->stock > 0)
                    <span class="inline-flex items-center text-[11px] font-medium text-slate-500 bg-slate-50 sm:bg-transparent px-2 py-0.5 sm:p-0 rounded-full border border-slate-100 sm:border-none">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 flex-shrink-0 animate-pulse"></span>
                        {{ $book->stock }} disponíveis
                    </span>
                @else
                    <span class="inline-flex items-center text-[11px] font-medium text-rose-600 bg-rose-50 sm:bg-transparent px-2 py-0.5 sm:p-0 rounded-full border border-rose-100 sm:border-none">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5 flex-shrink-0"></span>
                        Esgotado
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="flex items-center justify-between gap-2 mt-auto pt-2 border-t border-slate-50 sm:border-none">
        <div class="min-w-[100px] text-left">
            @auth
                @if(auth()->user()->hasRole('admin'))
                    <div class="h-full flex items-center justify-start py-2">
                        <a href="/admin/books/{{ $book->id }}/edit" class="text-xs text-slate-400 hover:text-slate-900 font-semibold transition-colors duration-150 relative z-10">
                            Editar Livro
                        </a>
                    </div>
                @else
                    @php
                        $isSaved = app(ReadingListService::class)->isBookSaved($book->id);
                    @endphp

                    <form action="{{ route('reading-list.toggle', $book->id) }}" method="POST" class="m-0 w-full relative z-10">
                        @csrf
                        @if($isSaved)
                            <x-button variant="secondary" class="!py-2 !px-3 text-xs rounded-xl w-full justify-center !text-emerald-700 !bg-emerald-50/50 hover:!bg-emerald-50 border border-emerald-200/60 shadow-sm transition-all flex items-center gap-1">
                                <x-heroicon-s-check class="w-3.5 h-3.5" />
                                <span>Guardado</span>
                            </x-button>
                        @else
                            <x-button variant="secondary" class="!py-2 !px-3 text-xs rounded-xl w-full justify-center !text-slate-700 !bg-slate-100 hover:!bg-slate-200 border border-slate-200/50 shadow-sm transition-all">
                                Ler mais tarde
                            </x-button>
                        @endif
                    </form>
                @endif
            @endauth
        </div>

        <div class="relative z-10 w-full sm:w-auto text-right">
            @if($book->stock > 0)
                <form action="{{ route('loans.store', $book->id) }}" method="POST" class="m-0 inline-block w-full sm:w-auto">
                    @csrf
                    <x-button variant="primary" class="!py-2 !px-4 text-xs rounded-xl w-full sm:w-auto justify-center">
                        Empréstimo
                    </x-button>
                </form>
            @else
                <button disabled class="inline-flex items-center justify-center bg-slate-100 text-slate-400 font-medium py-2 px-4 rounded-xl text-xs cursor-not-allowed w-full sm:w-auto">
                    Indisponível
                </button>
            @endif
        </div>
    </div>
</div>
