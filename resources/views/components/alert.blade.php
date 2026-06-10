@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl shadow-xs flex items-center gap-2">
        <span class="text-emerald-500">✓</span>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl shadow-xs flex items-center gap-2">
        <span class="text-red-500">✕</span>
        <span class="text-sm font-medium">{{ session('error') }}</span>
    </div>
@endif
