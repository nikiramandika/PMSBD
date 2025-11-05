@props(['title' => null, 'padding' => 'normal'])

@php
    $paddings = [
        'none' => '',
        'tight' => 'p-4',
        'normal' => 'p-6',
        'loose' => 'p-8',
    ];

    $paddingClass = $paddings[$padding];
@endphp

<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    @if($title)
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
        </div>
    @endif

    <div {{ $attributes->merge(['class' => $paddingClass]) }}>
        {{ $slot }}
    </div>
</div>