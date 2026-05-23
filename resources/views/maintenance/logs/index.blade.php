@extends('layouts.app')

@section('title', 'Maintenance Logs')
@section('page-title', 'Maintenance Logs')
@section('breadcrumb', 'Maintenance Logs')

@section('content')

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Maintenance Logs</h2>
            <p class="text-gray-600 text-sm mt-1">Riwayat & progress laporan maintenance</p>
        </div>
        @if(auth()->user()->isAdminOrOperator())
        <a href="{{ route('maintenance.create') }}"
           class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Laporan
        </a>
        @endif
    </div>

    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
        <div class="overflow-x-auto">
            <table id="logsTable" class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Asset</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Issue</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Teknisi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $log->asset->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-600 max-w-xs truncate">{{ $log->issue }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $log->assignee->name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($log->status == 'pending')       bg-yellow-100 text-yellow-800
                                    @elseif($log->status == 'in_progress') bg-blue-100 text-blue-800
                                    @elseif($log->status == 'resolved')    bg-green-100 text-green-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $log->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $log->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center space-x-3">
                                    <a href="{{ route('maintenance.show', $log->id) }}"
                                       class="text-blue-600 hover:text-blue-700">View</a>
                                    <a href="{{ route('maintenance.edit', $log->id) }}"
                                       class="text-yellow-600 hover:text-yellow-700">Edit</a>
                                    @if(auth()->user()->isAdminOrOperator())
                                    <form action="{{ route('maintenance.destroy', $log->id) }}"
                                          method="POST" class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700">Hapus</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada laporan maintenance</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#logsTable').DataTable({
        pageLength: 10,
        language: {
            search: "",
            searchPlaceholder: "Cari log...",
            emptyTable: "Belum ada log maintenance"
        },
        columnDefs: [
            { targets: '_all', defaultContent: '-' }
        ],
        dom:
            "<'flex items-center justify-between mb-4'lf>" +
            "t" +
            "<'flex items-center justify-between mt-4'ip>",
        initComplete: function() {
            $('div.dataTables_filter input').addClass('border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 ml-2');
            $('div.dataTables_length select').addClass('border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 mx-1');
        }
    });

    $('.delete-form').on('submit', function(e) {
        e.preventDefault();
        let form = this;
        Swal.fire({
            title: 'Hapus Log?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
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
</script>
@endpush