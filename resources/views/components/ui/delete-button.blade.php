{{--
  Delete Button with SweetAlert2 Confirmation
  Usage:
  <x-delete-button
    action="{{ route('assets.destroy', $asset) }}"
    message="This asset will be permanently deleted"
    title="Delete Asset?"
  />
--}}

@props([
    'action',
    'title' => 'Delete?',
    'message' => 'This action cannot be undone!',
    'confirmText' => 'Yes, delete it!',
    'cancelText' => 'Cancel',
    'size' => 'sm', // sm, md, lg
    'variant' => 'danger', // danger, secondary
])

@php
    $sizeClasses = match($size) {
        'sm' => 'px-3 py-1 text-xs',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
        default => 'px-4 py-2 text-sm',
    };

    $variantClasses = match($variant) {
        'danger' => 'text-red-600 hover:text-red-700 hover:bg-red-50',
        'secondary' => 'text-gray-600 hover:text-gray-700 hover:bg-gray-100',
        default => 'text-red-600 hover:text-red-700 hover:bg-red-50',
    };
@endphp

<form action="{{ $action }}" method="POST" class="delete-form inline">
    @csrf
    @method('DELETE')

    <button type="submit"
            class="transition-all duration-200 rounded-lg {{ $sizeClasses }} {{ $variantClasses }}">
        {{ $slot ?? 'Delete' }}
    </button>
</form>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: '{{ $title }}',
                        text: '{{ $message }}',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: '{{ $confirmText }}',
                        cancelButtonText: '{{ $cancelText }}'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
