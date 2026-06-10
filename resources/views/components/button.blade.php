@props([
    'type' => 'submit',
    'variant' => 'primary'
])

@php
    $classes = match($variant) {
        'primary' => 'bg-slate-900 hover:bg-slate-800 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition focus:outline-none focus:ring-2 focus:ring-emerald-500',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-3 rounded-lg text-sm shadow-sm transition focus:outline-none focus:ring-2 focus:ring-red-500',
        'secondary' => 'bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium py-1 px-3 rounded-lg text-sm transition focus:outline-none focus:ring-2 focus:ring-slate-400',
    };
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
