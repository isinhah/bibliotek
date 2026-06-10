<x-layout title="Meus Empréstimos">
    <div class="w-full max-w-5xl mx-auto">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Meus Empréstimos</h1>
            <p class="text-slate-500 text-sm mt-1">Acompanhe suas leituras atuais, prazos de devolução e histórico.</p>
        </div>

        <x-alert />

        <div class="mb-6 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <form action="{{ route('loans.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 m-0">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif

                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Pesquise pelo título do livro..." class="w-full px-4 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 text-slate-700">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium px-5 py-2 rounded-lg transition shadow-sm w-full sm:w-auto">
                        Buscar
                    </button>
                    @if(request('search'))
                        <a href="{{ route('loans.index', ['status' => request('status')]) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-medium px-4 py-2 rounded-lg transition inline-flex items-center justify-center">
                            Limpar
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="mb-6 border-b border-gray-200 flex flex-wrap gap-2">
            <a href="{{ route('loans.index', ['search' => request('search')]) }}" class="px-4 py-2 text-sm font-medium border-b-2 {{ request('status') == '' ? 'border-slate-900 text-slate-900 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
                Todos
            </a>
            <a href="{{ route('loans.index', ['status' => 'Pending', 'search' => request('search')]) }}" class="px-4 py-2 text-sm font-medium border-b-2 {{ request('status') == 'Pending' ? 'border-amber-500 text-amber-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
                Pendentes
            </a>
            <a href="{{ route('loans.index', ['status' => 'Active', 'search' => request('search')]) }}" class="px-4 py-2 text-sm font-medium border-b-2 {{ request('status') == 'Active' ? 'border-emerald-600 text-emerald-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
                Emprestados
            </a>
            <a href="{{ route('loans.index', ['status' => 'Overdue', 'search' => request('search')]) }}" class="px-4 py-2 text-sm font-medium border-b-2 {{ request('status') == 'Overdue' ? 'border-red-600 text-red-600 font-bold' : 'border-transparent text-slate-500 hover:text-red-500' }}">
                Atrasados
            </a>
            <a href="{{ route('loans.index', ['status' => 'Returned', 'search' => request('search')]) }}" class="px-4 py-2 text-sm font-medium border-b-2 {{ request('status') == 'Returned' ? 'border-green-600 text-green-600 font-semibold' : 'border-transparent text-slate-500 hover:text-green-700' }}">
                Devolvidos
            </a>
            <a href="{{ route('loans.index', ['status' => 'Cancelled', 'search' => request('search')]) }}" class="px-4 py-2 text-sm font-medium border-b-2 {{ request('status') == 'Cancelled' ? 'border-slate-400 text-slate-600 font-bold' : 'border-transparent text-slate-400 hover:text-slate-600' }}">
                Cancelados
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            @if($loans->isEmpty())
                <p class="p-12 text-center text-slate-500">Você não possui nenhum empréstimo nesta seção.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                        <tr class="bg-slate-50 border-b border-gray-100 text-slate-600 text-xs font-bold uppercase tracking-wider">
                            <th class="p-4">Livro</th>
                            <th class="p-4">Data Retirada</th>
                            <th class="p-4">Prazo Máximo</th>
                            <th class="p-4">Status</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                        @foreach($loans as $loan)
                            <tr class="hover:bg-slate-50/50 transition duration-150">

                                <td class="p-4 font-semibold text-slate-800 max-w-xs truncate" title="{{ $loan->book->title }}">
                                    {{ $loan->book->title }}
                                </td>

                                <td class="p-4 text-slate-500">
                                    @if($loan->status->value === 'Pending')
                                        <span class="text-xs text-amber-600 font-medium bg-amber-50 px-2.5 py-0.5 rounded-full border border-amber-100">Não retirado</span>
                                    @elseif($loan->status->value === 'Cancelled')
                                        <span class="text-xs text-slate-500 font-medium bg-slate-50 px-2.5 py-0.5 rounded-full border border-slate-100">Cancelado</span>
                                    @else
                                        {{ $loan->loan_date?->format('d/m/Y') }}
                                    @endif
                                </td>

                                <td class="p-4 font-mono text-xs font-semibold">
                                    @if($loan->status->value === 'Pending')
                                        <span class="text-slate-400 font-sans font-normal">Aguardando retirada</span>
                                    @elseif($loan->status->value === 'Cancelled')
                                        <span class="text-slate-400 font-sans font-normal line-through">Sem prazo</span>
                                    @elseif($loan->status->value === 'Returned')
                                        <span class="text-slate-400 line-through">Entregar em {{ $loan->due_date?->format('d/m/Y') }}</span>
                                        <div class="text-[11px] text-green-600 font-sans mt-0.5 font-semibold">Devolvido em: {{ $loan->return_date?->format('d/m/Y') }}</div>
                                    @elseif($loan->status->value === 'Overdue')
                                        <span class="text-red-600 font-bold">Venceu em {{ $loan->due_date?->format('d/m/Y') }}</span>
                                    @else
                                        <span class="text-emerald-600 font-bold">Até {{ $loan->due_date?->format('d/m/Y') }}</span>
                                    @endif
                                </td>

                                <td class="p-4">
                                    @if($loan->status->value === 'Pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-800 border border-amber-200 animate-pulse">
                                                Aguardando Retirada
                                        </span>
                                    @elseif($loan->status->value === 'Cancelled')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-50 text-slate-600 border border-slate-200">
                                                Cancelado
                                        </span>
                                    @elseif($loan->status->value === 'Returned')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-800 border border-green-200">
                                                Devolvido
                                        </span>
                                    @elseif($loan->status->value === 'Overdue')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-800 border border-red-200 animate-pulse">
                                                Atrasado
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-800 border border-emerald-200">
                                                Ativo
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-gray-100 [&_nav]:flex [&_nav]:justify-between [&_a]:bg-white [&_a]:text-slate-700 [&_a]:border-slate-200 [&_a]:hover:bg-slate-50 [&_span]:bg-slate-900 [&_span]:text-white [&_span]:border-slate-900">
                    {{ $loans->appends(request()->query())->links() }}
                </div>
            @endif
        </div>

    </div>
</x-layout>
