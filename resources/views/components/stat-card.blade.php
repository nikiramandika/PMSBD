@props(['title', 'value', 'trend' => null, 'color' => 'slate'])

@php
    $colors = [
        'slate' => [
            'bg' => 'bg-slate-50',
            'icon' => 'text-slate-600',
            'border' => 'border-slate-200'
        ],
        'emerald' => [
            'bg' => 'bg-emerald-50',
            'icon' => 'text-emerald-600',
            'border' => 'border-emerald-200'
        ],
        'blue' => [
            'bg' => 'bg-blue-50',
            'icon' => 'text-blue-600',
            'border' => 'border-blue-200'
        ],
        'amber' => [
            'bg' => 'bg-amber-50',
            'icon' => 'text-amber-600',
            'border' => 'border-amber-200'
        ],
        'red' => [
            'bg' => 'bg-red-50',
            'icon' => 'text-red-600',
            'border' => 'border-red-200'
        ],
        'purple' => [
            'bg' => 'bg-purple-50',
            'icon' => 'text-purple-600',
            'border' => 'border-purple-200'
        ],
        'orange' => [
            'bg' => 'bg-orange-50',
            'icon' => 'text-orange-600',
            'border' => 'border-orange-200'
        ]
    ];

    $colorClasses = $colors[$color];
@endphp

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-600">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $value }}</p>

            @if($trend)
                <div class="flex items-center mt-2">
                    @php
                        $isPositive = $trend['value'] > 0;
                        $trendColor = $isPositive ? 'text-emerald-600' : 'text-red-600';
                        $trendBg = $isPositive ? 'bg-emerald-50' : 'bg-red-50';
                    @endphp
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $trendColor }} {{ $trendBg }}">
                        @if($isPositive)
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        @else
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                            </svg>
                        @endif
                        {{ abs($trend['value']) }}% {{ $trend['label'] }}
                    </span>
                </div>
            @endif
        </div>

        <div class="flex-shrink-0">
            <div class="w-12 h-12 {{ $colorClasses['bg'] }} rounded-lg flex items-center justify-center">
                <div class="{{ $colorClasses['icon'] }}">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>