@extends('layouts.app')

@section('title', 'Maintenance Logs')
@section('page-title', 'Maintenance Logs')
@section('breadcrumb', 'Maintenance Logs')

@section('content')

<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Maintenance Logs</h2>
        <p class="text-gray-600 text-sm mt-1">
            @if(auth()->user()->role === 'teknisi')
                Kelola log yang ditugaskan ke kamu
            @else
                Seluruh riwayat laporan maintenance
            @endif
        </p>
    </div>
    @if(auth()->user()->role !== 'teknisi')
        <a href="{{ route('maintenance.create') }}"
           class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Log
        </a>
    @endif
</div>

{{-- TAB hanya muncul untuk teknisi --}}
@if(auth()->user()->role === 'teknisi')
<div class="mb-4 border-b border-gray-200">
    <nav class="flex space-x-4" id="log-tabs">
        <button onclick="switchTab('ditugaskan')"
                id="tab-ditugaskan"
                class="tab-btn px-4 py-2 text-sm font-medium border-b-2 border-green-600 text-green-600">
            Ditugaskan ke Saya
            <span class="ml-1 bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded-full">
                {{ $myLogs->count() }}
            </span>
        </button>
        <button onclick="switchTab('semua')"
                id="tab-semua"
                class="tab-btn px-4 py-2 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700">
            Semua Log
        </button>
    </nav>
</div>
@endif

{{-- TABEL: Ditugaskan ke Saya (hanya teknisi) --}}
@if(auth()->user()->role === 'teknisi')
<div id="panel-ditugaskan">
    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
        @include('maintenance.logs._table', [
            'tableId' => 'myLogsTable',
            'logs'    => $myLogs,
            'isOwn'   => true,
        ])
    </div>
</div>
@endif

{{-- TABEL: Semua Log --}}
<div id="panel-semua" {{ auth()->user()->role === 'teknisi' ? 'style=display:none' : '' }}>
    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
        @include('maintenance.logs._table', [
            'tableId' => 'allLogsTable',
            'logs'    => $allLogs,
            'isOwn'   => false,
        ])
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    initTable('myLogsTable');
    initTable('allLogsTable');

    $('.delete-form').on('submit', function(e) {
        e.preventDefault();
        let form = this;
        Swal.fire({
            title: 'Hapus Log?',
            text: "Log yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
});

function initTable(id) {
    if (!document.getElementById(id)) return;
    $('#' + id).DataTable({
        pageLength: 10,
        language: {
            search: "",
            searchPlaceholder: "Cari log...",
            emptyTable: "Belum ada log maintenance"
        },
        columnDefs: [{ targets: '_all', defaultContent: '-' }],
        dom:
            "<'flex items-center justify-between mb-4'lf>" +
            "t" +
            "<'flex items-center justify-between mt-4'ip>",
        initComplete: function() {
            $('div.dataTables_filter input').addClass('border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 ml-2');
            $('div.dataTables_length select').addClass('border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 mx-1');
        }
    });
}

function switchTab(tab) {
    document.getElementById('panel-ditugaskan').style.display = tab === 'ditugaskan' ? '' : 'none';
    document.getElementById('panel-semua').style.display      = tab === 'semua' ? '' : 'none';

    document.getElementById('tab-ditugaskan').className = 'tab-btn px-4 py-2 text-sm font-medium border-b-2 ' +
        (tab === 'ditugaskan' ? 'border-green-600 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700');
    document.getElementById('tab-semua').className = 'tab-btn px-4 py-2 text-sm font-medium border-b-2 ' +
        (tab === 'semua' ? 'border-green-600 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700');

    $.fn.DataTable.tables({ visible: true, api: true }).columns.adjust();
}
</script>
@endpush