@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 py-2 border-b-2 border-purple-500 text-sm font-medium text-gray-900 focus:outline-none focus:border-purple-700 transition-all duration-200 bg-gradient-to-b from-purple-50 to-transparent'
            : 'inline-flex items-center px-4 py-2 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition-all duration-200 hover:bg-gray-50';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
