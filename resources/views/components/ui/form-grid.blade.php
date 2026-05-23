{{--
  Form Grid - Responsive grid for form fields
  Usage:
  <x-form-grid>
    <x-input name="name" label="Name" />
    <x-input name="email" label="Email" />
  </x-form-grid>
--}}

@props(['cols' => 2])

<div @class([
    'grid gap-6',
    'grid-cols-1' => true,
    'md:grid-cols-2' => $cols >= 2,
    'lg:grid-cols-3' => $cols >= 3,
])>
    {{ $slot }}
</div>
