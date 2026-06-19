@if(session('success'))
    <div class="mb-8 p-4 bg-slate-900 border border-slate-800 text-white rounded-2xl shadow-sm flex items-center justify-between gap-3 animate-fade-in">
        <div class="flex items-center gap-2.5">
            <span class="w-2 h-2 rounded-full bg-[#b91c1c]"></span>
            <span class="text-sm font-medium tracking-tight">{{ session('success') }}</span>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="mb-8 p-4 bg-rose-50 border border-rose-100 text-rose-900 rounded-2xl shadow-sm flex items-center gap-2.5">
        <span class="text-rose-500 font-bold text-sm">✕</span>
        <span class="text-sm font-medium tracking-tight">{{ session('error') }}</span>
    </div>
@endif
