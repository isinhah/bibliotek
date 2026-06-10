<x-layout title="Painel de Empréstimos">
    <div class="w-full max-w-6xl mx-auto">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Painel de Empréstimos</h1>
            <p class="text-slate-500 text-sm mt-1">Monitore os prazos de entrega, atrasos e recebimento de devoluções.</p>
        </div>

        <x-alert />

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="p-6 pb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-100">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Registros de Empréstimos</h2>
                </div>

                <form action="{{ route('admin.loans.index') }}" method="GET" class="w-full sm:max-w-xs flex gap-2 m-0">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif

                    <div class="relative flex-1">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Pesquise pelo nome do leitor..."
                            class="w-full pl-3 pr-8 py-1.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 text-slate-700"
                        >
                        @if(request('search'))
                            <a href="{{ route('admin.loans.index', ['status' => request('status')]) }}" class="absolute right-2.5 top-2 text-slate-400 hover:text-slate-600 text-sm">
                                ✕
                            </a>
                        @endif
                    </div>
                    <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white text-xs font-medium px-4 py-1.5 rounded-lg transition shadow-sm">
                        Buscar
                    </button>
                </form>
            </div>

            <div class="bg-slate-50/50 px-6 border-b border-gray-100 flex flex-wrap gap-2">
                <a href="{{ route('admin.loans.index', ['search' => request('search')]) }}" class="px-3 py-3 text-xs font-bold border-b-2 transition {{ request('status') == '' ? 'border-slate-900 text-slate-900' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
                    Todos
                </a>
                <a href="{{ route('admin.loans.index', ['status' => 'Pending', 'search' => request('search')]) }}" class="px-3 py-3 text-xs font-bold border-b-2 transition {{ request('status') == 'Pending' ? 'border-amber-500 text-amber-600' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
                    Pendentes
                </a>
                <a href="{{ route('admin.loans.index', ['status' => 'Active', 'search' => request('search')]) }}" class="px-3 py-3 text-xs font-bold border-b-2 transition {{ request('status') == 'Active' ? 'border-emerald-600 text-emerald-600' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
                    Emprestados
                </a>
                <a href="{{ route('admin.loans.index', ['status' => 'Overdue', 'search' => request('search')]) }}" class="px-3 py-3 text-xs font-bold border-b-2 transition {{ request('status') == 'Overdue' ? 'border-red-600 text-red-600' : 'border-transparent text-slate-500 hover:text-red-500' }}">
                    Atrasados
                </a>
                <a href="{{ route('admin.loans.index', ['status' => 'Returned', 'search' => request('search')]) }}" class="px-3 py-3 text-xs font-bold border-b-2 transition {{ request('status') == 'Returned' ? 'border-green-600 text-green-600' : 'border-transparent text-slate-500 hover:text-green-700' }}">
                    Devolvidos
                </a>
                <a href="{{ route('admin.loans.index', ['status' => 'Cancelled', 'search' => request('search')]) }}" class="px-3 py-3 text-xs font-bold border-b-2 transition {{ request('status') == 'Cancelled' ? 'border-slate-400 text-slate-600' : 'border-transparent text-slate-400 hover:text-slate-600' }}">
                    Cancelados
                </a>
            </div>

            @if(request('search'))
                <div class="px-6 pt-4 text-xs text-slate-500">
                    Resultados para o leitor: <span class="font-semibold text-slate-800">"{{ request('search') }}"</span>
                </div>
            @endif

            @if($loans->isEmpty())
                <p class="p-12 text-center text-slate-500 text-sm">Nenhum registro de empréstimo encontrado nesta seção.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                        <tr class="bg-slate-50 border-b border-gray-100 text-slate-600 text-xs font-bold uppercase tracking-wider">
                            <th class="p-4 pl-6">Leitor</th>
                            <th class="p-4">Livro</th>
                            <th class="p-4">Data Retirada</th>
                            <th class="p-4">Prazo Máximo</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 pr-6 text-center">Ações de Controle</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                        @foreach($loans as $loan)
                            <tr class="hover:bg-slate-50/40 transition duration-150">

                                <td class="p-4 pl-6">
                                    <div class="font-semibold text-slate-800 capitalize">{{ $loan->user->name }}</div>
                                    <div class="text-xs text-slate-400 font-mono">{{ $loan->user->email }}</div>
                                </td>

                                <td class="p-4 font-semibold text-slate-700 max-w-xs truncate" title="{{ $loan->book->title }}">
                                    {{ $loan->book->title }}
                                </td>

                                <td class="p-4 text-slate-500">
                                    @if($loan->status->value === 'Pending')
                                        <span class="text-xs text-amber-600 font-medium bg-amber-50 px-2 py-0.5 rounded-full border border-amber-100">Não retirado</span>
                                    @elseif($loan->status->value === 'Cancelled')
                                        <span class="text-xs text-slate-500 font-medium bg-slate-50 px-2 py-0.5 rounded-full border border-slate-100">Cancelado</span>
                                    @else
                                        {{ $loan->loan_date?->format('d/m/Y') }}
                                    @endif
                                </td>

                                <td class="p-4 font-mono text-xs font-semibold">
                                    @if($loan->status->value === 'Pending')
                                        <span class="text-slate-400 font-sans font-normal">Aguardando liberação</span>
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
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-800 border border-amber-200">
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

                                <td class="p-4 pr-6 text-center">
                                    @if($loan->status->value === 'Pending')
                                        <div class="flex gap-2 justify-center">
                                            <form action="{{ route('admin.loans.pickup', $loan->id) }}" method="POST" onsubmit="return confirm('Confirmar que o leitor veio buscar o livro e iniciar o prazo de 30 dias?')" class="m-0">
                                                @csrf
                                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold py-1.5 px-3 rounded-lg transition shadow-xs whitespace-nowrap">
                                                    Confirmar Retirada
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.loans.cancel', $loan->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja cancelar esta reserva? O livro voltará para o estoque.')" class="m-0">
                                                @csrf
                                                <button type="submit" class="bg-slate-50 hover:bg-red-50 text-slate-600 hover:text-red-600 border border-slate-200/60 hover:border-red-200 text-xs font-semibold py-1.5 px-3 rounded-lg transition whitespace-nowrap">
                                                    Cancelar
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($loan->status->value === 'Active' || $loan->status->value === 'Overdue')
                                        <form action="{{ route('admin.loans.return', $loan->id) }}" method="POST" onsubmit="return confirm('Confirmar recebimento e devolução deste livro para o estoque?')" class="m-0">
                                            @csrf
                                            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold py-1.5 px-4 rounded-lg transition shadow-xs whitespace-nowrap">
                                                Receber Livro
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-300 font-medium select-none">Resolvido</span>
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
