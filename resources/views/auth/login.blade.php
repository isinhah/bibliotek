<x-layout title="Entrar — Bibliotek">
    <div class="max-w-md mx-auto bg-white p-10 rounded-2xl shadow-sm border border-slate-100 mt-16">
        <h2 class="text-3xl font-black text-slate-950 mb-8 text-center tracking-tighter">Acesse sua conta</h2>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label class="block text-slate-700 text-xs font-bold uppercase tracking-wider mb-2">E-mail</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#b91c1c] text-sm text-slate-800 transition-all @error('email') border-red-500 @enderror" required>
                @error('email') <span class="text-red-500 text-xs mt-1.5 block font-medium">{{ $message }}</span> @enderror
            </div>

            <div class="mb-8">
                <label class="block text-slate-700 text-xs font-bold uppercase tracking-wider mb-2">Senha</label>
                <input type="password" name="password"
                       class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#b91c1c] text-sm text-slate-800 transition-all" required>
            </div>

            <button type="submit" class="w-full bg-slate-950 hover:bg-[#b91c1c] text-white font-semibold py-3 rounded-2xl transition duration-200 shadow-sm mb-6 focus:outline-none">
                Entrar
            </button>

            <p class="text-center text-sm text-slate-500">
                Não tem uma conta?
                <a href="{{ route('register') }}" class="text-[#b91c1c] font-semibold hover:underline underline-offset-4 ml-1">
                    Cadastre-se
                </a>
            </p>
        </form>
    </div>
</x-layout>
