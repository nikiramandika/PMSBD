@props(['variant' => 'primary', 'size' => 'md', 'tag' => 'button'])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

    $variants = [
        'primary' => 'bg-slate-600 text-white hover:bg-slate-700 focus:ring-slate-500',
        'secondary' => 'bg-white text-slate-700 border border-slate-300 hover:bg-slate-50 focus:ring-slate-500',
        'success' => 'bg-emerald-600 text-white hover:bg-emerald-700 focus:ring-emerald-500',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
        'warning' => 'bg-amber-600 text-white hover:bg-amber-700 focus:ring-amber-500',
        'info' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    $classes = $baseClasses . ' ' . $variants[$variant] . ' ' . $sizes[$size];

    // Remove tag from attributes to avoid passing it to HTML
    $attributes = $attributes->except(['tag']);
@endphp

@php($dynamicTag = $tag === 'a' ? 'a' : 'button')

<{{ $dynamicTag }} {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</{{ $dynamicTag }}>