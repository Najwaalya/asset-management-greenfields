<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Asset Management System')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DATATABLE -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 h-screen overflow-hidden">

<div class="flex h-screen">

    <!-- SIDEBAR -->
    @include('components.layouts.sidebar')

    <!-- MAIN -->
    <div class="flex flex-col flex-1 h-full overflow-hidden">

        <!-- NAVBAR -->
        @include('components.layouts.navbar')

        <!-- 🔥 BREADCRUMB WAJIB ADA DI SINI -->
        @include('components.layouts.breadcrumb')

        <!-- CONTENT -->
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>

    </div>

</div>

@stack('scripts')

<!-- SIDEBAR SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const sidebar = document.getElementById('sidebar');
    const openBtn = document.getElementById('open-sidebar');

    openBtn?.addEventListener('click', function() {
        if (sidebar.classList.contains('w-0')) {
            // OPEN
            sidebar.classList.remove('w-0');
            sidebar.classList.add('w-64');
        } else {
            // CLOSE
            sidebar.classList.remove('w-64');
            sidebar.classList.add('w-0');
        }
    });

});
</script>

<!-- SWEETALERT -->
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: @json(session('success')),
        timer: 2000,
        showConfirmButton: false
    });
});
</script>
@endif

</body>
</html>