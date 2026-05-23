@php
    $breadcrumbString = trim($__env->yieldContent('breadcrumb'));

    if ($breadcrumbString === '') {
        $breadcrumbString = trim($__env->yieldContent('page-title'));
    }

    $segments = array_filter(array_map('trim', preg_split('/\s*\/\s*/', $breadcrumbString)));

    $items = [];
    $url = '';

    foreach ($segments as $index => $segment) {

        if (strcasecmp($segment, 'Dashboard') === 0) {
            continue;
        }

        // bikin URL incremental (simple auto routing style)
        $url .= '/' . strtolower(str_replace(' ', '-', $segment));

        $items[] = [
            'label' => $segment,
            'url' => $url
        ];
    }
@endphp

<nav class="bg-green-50/60 backdrop-blur border-b border-green-200 px-4 py-3 text-sm" aria-label="Breadcrumb">

    <div class="flex items-center flex-wrap text-green-600">

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
           class="text-green-700 hover:text-green-900 font-medium">
            Dashboard
        </a>

        @foreach($items as $item)

            <span class="mx-2 text-gray-400">›</span>

            <a href="{{ $item['url'] }}"
               class="text-green-700 hover:text-green-900 font-medium">
                {{ $item['label'] }}
            </a>

        @endforeach

    </div>

</nav>