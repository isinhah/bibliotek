<x-layout title="Criar Conta">
    <div class="max-w-md mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-100 mt-6">
        <h2 class="text-2xl font-bold text-slate-800 mb-6 text-center">Cadastre-se</h2>

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Nome Completo</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 text-slate-700" required>
            </div>

            <div class="mb-4">
                <label class="block text-slate-700 text-sm font-semibold mb-2">E-mail</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 text-slate-700 @error('email') border-red-500 @enderror" required>
                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Senha</label>
                <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 text-slate-700 @error('password') border-red-500 @enderror" required>
                @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Confirme a Senha</label>
                <input type="password" name="password_confirmation" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 text-slate-700" required>
            </div>

            <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-medium py-2.5 rounded-lg transition shadow-sm mb-4 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                Criar Conta
            </button>
        </form>
    </div>
</x-layout>
