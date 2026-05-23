<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\MaintenanceLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceLogController extends Controller
{
    /**
     * List semua log
     */
    public function index()
    {
        $user = Auth::user();

        // Teknisi hanya lihat log yang di-assign ke dia
        $logs = MaintenanceLog::with(['asset', 'reporter', 'assignee', 'schedule'])
            ->when($user->isTeknisi(), fn($q) => $q->where('assigned_to', $user->id))
            ->latest()
            ->get();

        return view('maintenance.logs.index', compact('logs'));
    }

    /**
     * Form buat log baru
     */
    public function create()
    {
        // Teknisi tidak bisa buat log manual
        if (Auth::user()->isTeknisi()) {
            abort(403);
        }

        $assets   = Asset::all();
        $teknisis = User::where('role', 'teknisi')->get();

        return view('maintenance.logs.create', compact('assets', 'teknisis'));
    }

    /**
     * Simpan log baru
     */
    public function store(Request $request)
    {
        if (Auth::user()->isTeknisi()) {
            abort(403);
        }

        $request->validate([
            'asset_id'    => 'required|exists:assets,id',
            'assigned_to' => 'nullable|exists:users,id',
            'issue'       => 'required|string',
            'status'      => 'required|in:pending,in_progress,resolved',
        ]);

        MaintenanceLog::create([
            'asset_id'    => $request->asset_id,
            'schedule_id' => $request->schedule_id ?? null,
            'reported_by' => Auth::id(),
            'assigned_to' => $request->assigned_to,
            'issue'       => $request->issue,
            'solution'    => $request->solution,
            'status'      => $request->status,
            'resolved_at' => $request->status === 'resolved' ? now() : null,
        ]);

        $asset = Asset::find($request->asset_id);
        if ($request->status !== 'resolved') {
            $asset->update(['status' => 'maintenance']);
        }

        return redirect()
            ->route('maintenance.index')
            ->with('success', 'Laporan maintenance berhasil dibuat');
    }

    /**
     * Detail log
     */
    public function show($id)
    {
        $user = Auth::user();
        $log  = MaintenanceLog::with(['asset', 'reporter', 'assignee', 'schedule'])
            ->findOrFail($id);

        // Teknisi hanya bisa lihat log miliknya
        if ($user->isTeknisi() && $log->assigned_to !== $user->id) {
            abort(403);
        }

        return view('maintenance.logs.show', compact('log'));
    }

    /**
     * Form edit — teknisi hanya bisa update status & solusi
     */
    public function edit($id)
    {
        $user = Auth::user();
        $log  = MaintenanceLog::findOrFail($id);

        if ($user->isTeknisi() && $log->assigned_to !== $user->id) {
            abort(403);
        }

        $assets   = Asset::all();
        $teknisis = User::where('role', 'teknisi')->get();

        return view('maintenance.logs.edit', compact('log', 'assets', 'teknisis'));
    }

    /**
     * Update log
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $log  = MaintenanceLog::findOrFail($id);

        if ($user->isTeknisi() && $log->assigned_to !== $user->id) {
            abort(403);
        }

        // Teknisi hanya boleh update status & solusi
        if ($user->isTeknisi()) {
            $request->validate([
                'status'   => 'required|in:pending,in_progress,resolved',
                'solution' => 'nullable|string',
            ]);

            $log->update([
                'status'      => $request->status,
                'solution'    => $request->solution,
                'resolved_at' => $request->status === 'resolved' ? now() : null,
            ]);

        } else {
            $request->validate([
                'asset_id'    => 'required|exists:assets,id',
                'assigned_to' => 'nullable|exists:users,id',
                'issue'       => 'required|string',
                'status'      => 'required|in:pending,in_progress,resolved',
            ]);

            $log->update([
                'asset_id'    => $request->asset_id,
                'assigned_to' => $request->assigned_to,
                'issue'       => $request->issue,
                'solution'    => $request->solution,
                'status'      => $request->status,
                'resolved_at' => $request->status === 'resolved' ? now() : null,
            ]);

            $asset = Asset::find($request->asset_id);
            $asset->update([
                'status' => $request->status === 'resolved' ? 'normal' : 'maintenance'
            ]);
        }

        return redirect()
            ->route('maintenance.index')
            ->with('success', 'Data maintenance berhasil diperbarui');
    }

    /**
     * Hapus log — teknisi tidak bisa hapus
     */
    public function destroy($id)
    {
        if (Auth::user()->isTeknisi()) {
            abort(403);
        }

        $log = MaintenanceLog::findOrFail($id);
        $log->delete();

        return redirect()
            ->route('maintenance.index')
            ->with('success', 'Data maintenance berhasil dihapus');
    }
}