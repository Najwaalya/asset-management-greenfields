{{--
  Reusable Search & Filter Bar
  Usage:
  <x-search-bar
    search_placeholder="Search assets..."
    :filters="[
        'status' => ['normal' => 'Normal', 'maintenance' => 'Maintenance', 'broken' => 'Broken'],
        'category' => $categories,
    ]"
  />
--}}

@props([
    'searchPlaceholder' => 'Search...',
    'filters' => [],
    'sortOptions' => [],
])

<div class="bg-white rounded-xl shadow border border-gray-200 p-6 mb-6">

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        {{-- Search Input --}}
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
            <input type="text"
                   placeholder="{{ $searchPlaceholder }}"
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm
                          focus:ring-2 focus:ring-green-500 focus:border-transparent
                          transition-all duration-200"
                   name="search">
        </div>

        {{-- Filters --}}
        @foreach($filters as $filterName => $filterOptions)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2 capitalize">
                    {{ str_replace('_', ' ', $filterName) }}
                </label>

                <select name="{{ $filterName }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm bg-white
                               focus:ring-2 focus:ring-green-500 focus:border-transparent
                               transition-all duration-200">

                    <option value="">All {{ str_replace('_', ' ', $filterName) }}</option>

                    @if(is_array($filterOptions))
                        @foreach($filterOptions as $value => $label)
                            <option value="{{ $value }}">
                                {{ is_object($label) ? $label->name : $label }}
                            </option>
                        @endforeach
                    @endif

                </select>
            </div>
        @endforeach

        {{-- Sort --}}
        @if(count($sortOptions) > 0)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                <select name="sort"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm bg-white
                               focus:ring-2 focus:ring-green-500 focus:border-transparent
                               transition-all duration-200">

                    @foreach($sortOptions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach

                </select>
            </div>
        @endif

    </div>

    {{-- Action Buttons --}}
    <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200">

        <div class="flex items-center space-x-2">
            <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700
                           transition-all duration-200 text-sm font-medium">
                Apply Filter
            </button>

            <a href="{{ request()->url() }}"
               class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200
                      transition-all duration-200 text-sm font-medium">
                Reset
            </a>
        </div>

        {{-- Slot for additional buttons --}}
        {{ $actions ?? '' }}

    </div>

</div>
