@props([
    'title' => '',
    'value' => '0',
    'icon' => '',
    'trend' => null,
    'color' => 'green',
])

@php
    $cardClass = match($color) {
        'green'  => 'border-l-4 border-l-green-500 bg-white',
        'red'    => 'border-l-4 border-l-red-500 bg-white',
        'yellow' => 'border-l-4 border-l-yellow-500 bg-white',
        'blue'   => 'border-l-4 border-l-blue-500 bg-white',
        default  => 'border-l-4 border-l-green-500 bg-white',
    };

    $iconBgClass = match($color) {
        'green'  => 'bg-green-50 text-green-600',
        'red'    => 'bg-red-50 text-red-600',
        'yellow' => 'bg-yellow-50 text-yellow-600',
        'blue'   => 'bg-blue-50 text-blue-600',
        default  => 'bg-green-50 text-green-600',
    };

    $trendColorClass = $trend && $trend >= 0 ? 'text-green-600' : 'text-red-500';
@endphp

<div class="rounded-lg shadow border border-gray-200 {{ $cardClass }} p-6 hover:shadow-md transition-all duration-300">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-gray-500 text-sm font-medium">{{ $title }}</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $value }}</p>
            @if($trend !== null)
                <p class="text-xs {{ $trendColorClass }} font-medium mt-2">
                    @if($trend > 0)
                        ↑ {{ $trend }}% from last month
                    @elseif($trend < 0)
                        ↓ {{ abs($trend) }}% from last month
                    @else
                        → No change
                    @endif
                </p>
            @endif
        </div>
        <div class="p-3 rounded-lg {{ $iconBgClass }}">
            {!! $icon !!}
        </div>
    </div>
</div>