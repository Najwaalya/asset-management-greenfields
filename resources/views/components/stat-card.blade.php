@props([
    'title' => '',
    'value' => '0',
    'icon' => '',
    'trend' => null,
    'color' => 'green',
])

@php
    $bgColorClass = match($color) {
        'green' => 'bg-green-50 border-green-100',
        'red' => 'bg-red-50 border-red-100',
        'yellow' => 'bg-yellow-50 border-yellow-100',
        'blue' => 'bg-blue-50 border-blue-100',
        default => 'bg-green-50 border-green-100',
    };

    $iconColorClass = match($color) {
        'green' => 'text-greenfields-natural',
        'red' => 'text-red-600',
        'yellow' => 'text-yellow-600',
        'blue' => 'text-blue-600',
        default => 'text-greenfields-natural',
    };

    $trendColorClass = $trend && $trend >= 0 ? 'text-green-600' : 'text-red-600';
@endphp

<div class="bg-white rounded-lg shadow border {{ $bgColorClass }} p-6 hover:shadow-lg hover:border-gray-200 transition-all duration-300">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-gray-600 text-sm font-medium">{{ $title }}</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $value }}</p>
            @if($trend !== null)
                <p class="text-xs {{ $trendColorClass }} font-semibold mt-2">
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
        <div class="p-3 bg-gradient-to-br from-greenfields-natural/20 to-greenfields-natural/10 rounded-lg">
            {!! $icon !!}
        </div>
    </div>
</div>
