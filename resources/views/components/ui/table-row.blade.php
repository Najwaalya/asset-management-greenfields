{{--
  Table Row with Standard Styling
  Auto-handles hover effect
--}}

@props(['hover' => true])

<tr @class([
    'hover:bg-gray-50 transition-colors duration-200' => $hover,
    'border-b border-gray-100' => true,
])>
    {{ $slot }}
</tr>
