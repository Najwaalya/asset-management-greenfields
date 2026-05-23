{{--
  Modern Data Table Component
  Usage:
  <x-data-table>
    <x-slot:headers>
      <th>No</th>
      <th>Name</th>
      <th>Status</th>
      <th>Created</th>
      <th>Actions</th>
    </x-slot:headers>

    <tbody>
      @foreach($items as $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $item->name }}</td>
          <td><x-badge :status="$item->status" /></td>
          <td>{{ $item->created_at->format('d M Y') }}</td>
          <td>
            <x-action-dropdown>
              <a href="{{ route('items.edit', $item) }}" class="block px-4 py-2 text-sm hover:bg-gray-50">Edit</a>
            </x-action-dropdown>
          </td>
        </tr>
      @endforeach
    </tbody>
  </x-data-table>
--}}

@props([
    'title' => null,
    'description' => null,
    'stripe' => true,
    'border' => true,
])

<div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden">

    {{-- Header --}}
    @if($title)
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50/50">
            <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
            @if($description)
                <p class="text-sm text-gray-600 mt-1">{{ $description }}</p>
            @endif
        </div>
    @endif

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full">

            {{-- Headers --}}
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    {{ $headers }}
                </tr>
            </thead>

            {{-- Body --}}
            <tbody @class([
                'divide-y divide-gray-200' => $stripe,
            ])>
                {{ $slot }}
            </tbody>

        </table>
    </div>

    {{-- Empty State --}}
    @isset($empty)
        @if (empty($slot))
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p class="text-gray-600 mt-2">{{ $empty ?? 'No data available' }}</p>
            </div>
        @endif
    @endisset

    {{-- Footer / Pagination --}}
    @isset($footer)
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $footer }}
        </div>
    @endisset

</div>
