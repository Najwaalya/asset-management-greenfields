{{--
  Form Card Wrapper Component
  Usage:
  <x-form-card title="Create Asset" description="Add new asset to inventory">
    <form action="{{ route('assets.store') }}" method="POST">
      @csrf
      <div class="space-y-4">
        <x-input name="name" label="Asset Name" required />
        <x-select name="category_id" label="Category" :options="$categories" />
      </div>

      <x-slot:footer>
        <a href="{{ route('assets.index') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Create</button>
      </x-slot:footer>
    </form>
  </x-form-card>
--}}

@props([
    'title' => null,
    'description' => null,
    'icon' => null,
    'maxWidth' => 'max-w-2xl',
    'action' => null,
])

<div class="py-6">

    {{-- Header with optional action button --}}
    <div class="mb-8 flex items-center justify-between">
        <div>
            @if($title)
                <h2 class="text-2xl font-bold text-gray-900">{{ $title }}</h2>
                @if($description)
                    <p class="text-gray-600 text-sm mt-1">{{ $description }}</p>
                @endif
            @endif
        </div>

        @if($action)
            {{ $action }}
        @endif
    </div>

    {{-- Form Card Container --}}
    <div class="{{ $maxWidth }} mx-auto bg-white rounded-xl shadow border border-gray-200 overflow-hidden">

        {{-- Content Area --}}
        <div class="p-8">
            {{ $slot }}
        </div>

        {{-- Footer with action buttons --}}
        @isset($footer)
            <div class="px-8 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-end space-x-3">
                {{ $footer }}
            </div>
        @endisset

    </div>

</div>
